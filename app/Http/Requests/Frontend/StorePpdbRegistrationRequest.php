<?php

namespace App\Http\Requests\Frontend;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class StorePpdbRegistrationRequest extends FormRequest
{
    /**
     * Semua orang tua/wali murid diizinkan mengakses endpoint publik ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sanitasi input dari tag HTML berbahaya (XSS) dan normalisasi format angka sebelum divalidasi.
     */
    protected function prepareForValidation(): void
    {
        $sanitized = [];

        $textFields = [
            'child_full_name',
            'child_birth_place',
            'parent_name',
            'parent_occupation',
            'home_address',
        ];

        foreach ($textFields as $field) {
            if ($this->has($field) && is_string($this->input($field))) {
                $cleaned = strip_tags($this->input($field));
                $cleaned = (string) preg_replace('/\s+/u', ' ', trim($cleaned));
                $sanitized[$field] = $cleaned;
            }
        }

        if ($this->has('child_nik') && is_string($this->input('child_nik'))) {
            $sanitized['child_nik'] = preg_replace('/[^0-9]/', '', $this->input('child_nik'));
        }

        if ($this->filled('parent_nik') && is_string($this->input('parent_nik'))) {
            $sanitized['parent_nik'] = preg_replace('/[^0-9]/', '', $this->input('parent_nik'));
        }

        if ($this->has('parent_phone') && is_string($this->input('parent_phone'))) {
            $phone = (string) preg_replace('/[^0-9]/', '', $this->input('parent_phone'));
            $sanitized['parent_phone'] = $phone;
        }

        if ($sanitized !== []) {
            $this->merge($sanitized);
        }
    }

    /**
     * Aturan validasi form pendaftaran PPDB.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentYear = (int) date('Y');
        $minBirthDate = Carbon::create($currentYear - 13, 1, 1)->toDateString();
        $maxBirthDate = Carbon::create($currentYear - 5, 12, 31)->toDateString();

        return [
            'period_id' => [
                'required',
                'integer',
                Rule::exists('trn_ppdb_periods', 'id')->where('is_open', 1),
            ],
            'website_url' => ['nullable', 'string'],
            'form_rendered_at' => ['required', 'string'],
            'security_answer' => ['required', 'numeric'],
            'child_full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\pL\s\.\,\'\-]+$/u',
            ],
            'child_nik' => [
                'required',
                'string',
                'digits:16',
                'not_regex:/^(\d)\1{15}$/',
                Rule::unique('trn_ppdb_registrations', 'child_nik')
                    ->where(fn ($query) => $query->where('period_id', $this->input('period_id'))),
            ],
            'child_gender' => ['required', Rule::in(['L', 'P'])],
            'child_birth_place' => ['required', 'string', 'min:2', 'max:50'],
            'child_birth_date' => [
                'required',
                'date',
                "after_or_equal:{$minBirthDate}",
                "before_or_equal:{$maxBirthDate}",
            ],
            'track' => [
                'required',
                Rule::in(['zonasi', 'afirmasi', 'perpindahan_ortu', 'reguler']),
            ],
            'parent_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\pL\s\.\,\'\-]+$/u',
            ],
            'parent_nik' => [
                'nullable',
                'string',
                'digits:16',
                'not_regex:/^(\d)\1{15}$/',
            ],
            'parent_phone' => [
                'required',
                'string',
                'regex:/^(08|628)[0-9]{7,13}$/',
            ],
            'parent_email' => ['nullable', 'email', 'max:80'],
            'parent_occupation' => ['nullable', 'string', 'max:50'],
            'home_address' => ['required', 'string', 'min:10', 'max:255'],
            'distance_meters' => ['nullable', 'integer', 'min:0', 'max:50000'],
            'document_kk' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf,webp', 'max:3072'],
            'document_akta' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf,webp', 'max:3072'],
            'document_kia' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf,webp', 'max:3072'],
        ];
    }

    /**
     * Pemeriksaan lanjutan untuk Honeypot, Encrypted Time-Trap, dan Math Challenge.
     *
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                // 1. Pemeriksaan Honeypot (Anti-Bot)
                if (filled($this->input('website_url'))) {
                    Log::warning('PPDB Security Alert: Honeypot field filled by bot', [
                        'ip' => $this->ip(),
                        'user_agent' => $this->userAgent(),
                    ]);

                    $validator->errors()->add(
                        'website_url',
                        'Permintaan ditolak karena terdeteksi aktivitas otomatis yang tidak sah.'
                    );

                    return;
                }

                // 2. Pemeriksaan Encrypted Time-Trap (Minimal 4 detik sejak form dimuat)
                $encryptedTimestamp = (string) $this->input('form_rendered_at', '');
                if ($encryptedTimestamp !== '') {
                    try {
                        $renderedAt = (int) Crypt::decryptString($encryptedTimestamp);
                        $elapsedSeconds = now()->timestamp - $renderedAt;

                        if ($elapsedSeconds < 4) {
                            Log::warning('PPDB Security Alert: Form submitted too fast (Time-Trap triggered)', [
                                'ip' => $this->ip(),
                                'elapsed_seconds' => $elapsedSeconds,
                                'user_agent' => $this->userAgent(),
                            ]);

                            $validator->errors()->add(
                                'form_rendered_at',
                                'Pengiriman formulir terlalu cepat. Mohon periksa kembali kelengkapan data Anda sebelum mengirim.'
                            );
                        } elseif ($elapsedSeconds > 7200) {
                            $validator->errors()->add(
                                'form_rendered_at',
                                'Sesi formulir telah kedaluwarsa (lebih dari 2 jam). Silakan muat ulang halaman dan coba lagi.'
                            );
                        }
                    } catch (Throwable) {
                        Log::warning('PPDB Security Alert: Invalid encrypted timestamp token', [
                            'ip' => $this->ip(),
                            'user_agent' => $this->userAgent(),
                        ]);

                        $validator->errors()->add(
                            'form_rendered_at',
                            'Token keamanan waktu formulir tidak valid. Silakan muat ulang halaman.'
                        );
                    }
                }

                // 3. Pemeriksaan Jawaban Math Challenge (One-Time Session Validation)
                $expectedAnswer = $this->session()->pull('ppdb_math_answer');
                if ($expectedAnswer === null || (int) $this->input('security_answer') !== (int) $expectedAnswer) {
                    Log::warning('PPDB Security Alert: Invalid math challenge answer', [
                        'ip' => $this->ip(),
                        'user_agent' => $this->userAgent(),
                    ]);

                    $validator->errors()->add(
                        'security_answer',
                        'Jawaban verifikasi keamanan (berhitung) belum tepat. Silakan jawab sesuai pertanyaan yang tampil.'
                    );
                }
            },
        ];
    }

    /**
     * Pesan kesalahan validasi berbahasa Indonesia yang jelas bagi orang tua murid.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'period_id.required' => 'Gelombang pendaftaran PPDB wajib dipilih.',
            'period_id.exists' => 'Gelombang pendaftaran PPDB yang dipilih sedang ditutup atau tidak aktif.',
            'form_rendered_at.required' => 'Token keamanan formulir tidak ditemukan. Silakan muat ulang halaman.',
            'security_answer.required' => 'Pertanyaan verifikasi keamanan wajib dijawab.',
            'security_answer.numeric' => 'Jawaban verifikasi keamanan harus berupa angka.',
            'child_full_name.required' => 'Nama lengkap calon siswa wajib diisi.',
            'child_full_name.regex' => 'Nama lengkap calon siswa hanya boleh berisi huruf dan tanda baca nama yang wajar.',
            'child_nik.required' => 'NIK calon siswa wajib diisi.',
            'child_nik.digits' => 'NIK calon siswa wajib terdiri dari tepat 16 digit angka sesuai Kartu Keluarga.',
            'child_nik.not_regex' => 'Format NIK calon siswa tidak valid.',
            'child_nik.unique' => 'NIK calon siswa ini sudah terdaftar pada gelombang PPDB berjalan. Silakan hubungi Panitia PPDB jika ingin memperbarui berkas.',
            'child_birth_date.required' => 'Tanggal lahir calon siswa wajib diisi.',
            'child_birth_date.after_or_equal' => 'Tanggal lahir calon siswa melewati batas usia maksimal pendaftaran SD.',
            'child_birth_date.before_or_equal' => 'Usia calon siswa belum memenuhi batas minimal pendaftaran SD.',
            'parent_name.required' => 'Nama orang tua/wali wajib diisi.',
            'parent_name.regex' => 'Nama orang tua/wali hanya boleh berisi huruf dan tanda baca nama yang wajar.',
            'parent_nik.digits' => 'NIK orang tua/wali harus terdiri dari tepat 16 digit angka.',
            'parent_nik.not_regex' => 'Format NIK orang tua/wali tidak valid.',
            'parent_phone.required' => 'Nomor WhatsApp aktif orang tua/wali wajib diisi.',
            'parent_phone.regex' => 'Format nomor WhatsApp tidak valid (gunakan awalan 08 atau 628, contoh: 081234567890).',
            'home_address.required' => 'Alamat lengkap domisili tempat tinggal wajib diisi.',
            'home_address.min' => 'Alamat domisili terlalu singkat (minimal 10 karakter).',
            'document_kk.mimes' => 'Berkas Kartu Keluarga (KK) harus berformat JPG, PNG, WEBP, atau PDF.',
            'document_kk.max' => 'Ukuran berkas Kartu Keluarga (KK) maksimal 3 MB.',
            'document_akta.mimes' => 'Berkas Akta Kelahiran harus berformat JPG, PNG, WEBP, atau PDF.',
            'document_akta.max' => 'Ukuran berkas Akta Kelahiran maksimal 3 MB.',
            'document_kia.mimes' => 'Berkas KIA/Afirmasi harus berformat JPG, PNG, WEBP, atau PDF.',
            'document_kia.max' => 'Ukuran berkas KIA/Afirmasi maksimal 3 MB.',
        ];
    }
}

