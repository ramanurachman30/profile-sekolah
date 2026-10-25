<?php

namespace App\Services;

use App\Models\PpdbRegistration;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class PpdbEnrollmentService
{
    /**
     * Terima pendaftar PPDB, buat record siswa resmi di mst_students,
     * dan perbarui status pendaftaran menjadi 'diterima'.
     *
     * @param PpdbRegistration $registration
     * @param int|null $verifiedByUserId
     * @param int|null $classRoomId
     * @return Student
     * @throws Exception
     */
    public function acceptRegistration(PpdbRegistration $registration, ?int $verifiedByUserId = null, ?int $classRoomId = null): Student
    {
        if ($registration->verification_status === 'diterima' && $registration->enrolled_student_id) {
            $existingStudent = Student::find($registration->enrolled_student_id);
            if ($existingStudent) {
                return $existingStudent;
            }
        }

        return DB::transaction(function () use ($registration, $verifiedByUserId, $classRoomId) {
            // Cek apakah siswa dengan NIK ini sudah ada di mst_students
            $student = Student::where('nik', $registration->child_nik)->first();

            if (! $student) {
                $student = Student::create([
                    'nik' => $registration->child_nik,
                    'full_name' => $registration->child_full_name,
                    'gender' => $registration->child_gender,
                    'birth_place' => $registration->child_birth_place,
                    'birth_date' => $registration->child_birth_date,
                    'parent_guardian_name' => $registration->parent_name,
                    'parent_phone' => $registration->parent_phone,
                    'address' => $registration->home_address,
                    'current_class_id' => $classRoomId,
                    'status' => 'aktif',
                    'photo_asset_id' => $registration->document_kia_asset_id,
                ]);
            } else {
                $student->update([
                    'status' => 'aktif',
                    'current_class_id' => $classRoomId ?? $student->current_class_id,
                ]);
            }

            $registration->update([
                'verification_status' => 'diterima',
                'enrolled_student_id' => $student->id,
                'verified_by_user_id' => $verifiedByUserId ?? auth()->id(),
                'verified_at' => now(),
                'rejection_reason' => null,
            ]);

            return $student;
        });
    }

    /**
     * Tolak pendaftaran PPDB dengan menyertakan alasan.
     *
     * @param PpdbRegistration $registration
     * @param string $reason
     * @param int|null $verifiedByUserId
     * @return bool
     */
    public function rejectRegistration(PpdbRegistration $registration, string $reason, ?int $verifiedByUserId = null): bool
    {
        return $registration->update([
            'verification_status' => 'ditolak',
            'rejection_reason' => $reason,
            'verified_by_user_id' => $verifiedByUserId ?? auth()->id(),
            'verified_at' => now(),
        ]);
    }
}
