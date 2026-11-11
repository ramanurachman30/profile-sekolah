<?php

namespace App\Services;

use App\Models\MediaAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MediaAssetService
{
    /**
     * Whitelist ketat pemetaan MIME type ke ekstensi server yang aman.
     *
     * @var array<string, string>
     */
    private const ALLOWED_MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'application/pdf' => 'pdf',
    ];

    /**
     * Upload dan simpan file ke media assets, dengan inspeksi MIME ketat,
     * validasi magic bytes PDF, dan konversi otomatis gambar ke .webp.
     */
    public function upload(
        UploadedFile $file,
        ?string $altText = null,
        string $disk = 'public',
        ?string $uuidPrefix = null,
        ?string $subDirectory = null
    ): MediaAsset {
        $originalName = $file->getClientOriginalName();
        $mimeType = strtolower((string) ($file->getMimeType() ?? 'application/octet-stream'));

        if (! isset(self::ALLOWED_MIME_EXTENSIONS[$mimeType])) {
            throw ValidationException::withMessages([
                'file' => 'Tipe berkas tidak diizinkan oleh kebijakan keamanan server.',
            ]);
        }

        $safeExtension = self::ALLOWED_MIME_EXTENSIONS[$mimeType];

        if ($safeExtension === 'pdf' && ! $this->hasValidPdfMagicBytes($file)) {
            throw ValidationException::withMessages([
                'file' => 'Berkas PDF tidak valid atau terdeteksi telah dimanipulasi.',
            ]);
        }

        $fileType = $this->determineFileType($mimeType);

        $year = date('Y');
        $month = date('m');
        $cleanSubDir = $subDirectory !== null ? trim($subDirectory, '/').'/' : '';
        $directory = "uploads/{$cleanSubDir}{$year}/{$month}";

        $baseFileName = $uuidPrefix !== null
            ? Str::slug($uuidPrefix, '_').'_'.Str::uuid()->toString()
            : (Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) ?: 'media').'_'.Str::random(8);

        $safeOriginalDisplayName = strip_tags(pathinfo($originalName, PATHINFO_FILENAME)).'.'.$safeExtension;

        // Jika file berupa gambar dan bukan gif animasi, konversi ke .webp untuk membersihkan metadata EXIF berbahaya
        if ($fileType === 'image' && $mimeType !== 'image/gif' && function_exists('imagewebp')) {
            $converted = $this->convertToWebp($file);
            if ($converted !== null) {
                $fileName = "{$baseFileName}.webp";
                $filePath = "{$directory}/{$fileName}";

                Storage::disk($disk)->put($filePath, $converted['content']);
                $fileSizeKb = (int) ceil(strlen($converted['content']) / 1024);

                return MediaAsset::create([
                    'file_path' => $filePath,
                    'file_name' => $safeOriginalDisplayName,
                    'file_type' => 'image',
                    'mime_type' => 'image/webp',
                    'file_size_kb' => $fileSizeKb,
                    'alt_text' => $altText ?? strip_tags(pathinfo($originalName, PATHINFO_FILENAME)),
                ]);
            }
        }

        // Simpan menggunakan ekstensi aman dari hasil pemetaan MIME (tanpa getClientOriginalExtension)
        $fileName = "{$baseFileName}.{$safeExtension}";
        $filePath = Storage::disk($disk)->putFileAs($directory, $file, $fileName);
        $fileSizeKb = (int) ceil($file->getSize() / 1024);

        return MediaAsset::create([
            'file_path' => $filePath,
            'file_name' => $safeOriginalDisplayName,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size_kb' => $fileSizeKb,
            'alt_text' => $altText ?? strip_tags(pathinfo($originalName, PATHINFO_FILENAME)),
        ]);
    }

    /**
     * Periksa magic bytes (%PDF-) pada 5 byte pertama berkas PDF.
     */
    public function hasValidPdfMagicBytes(UploadedFile $file): bool
    {
        $realPath = $file->getRealPath();
        if ($realPath === false || ! is_readable($realPath)) {
            return false;
        }

        $handle = @fopen($realPath, 'rb');
        if ($handle === false) {
            return false;
        }

        $header = fread($handle, 5);
        fclose($handle);

        return $header === '%PDF-';
    }

    /**
     * Tentukan tipe media ('image', 'video', 'document').
     */
    protected function determineFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }

        return 'document';
    }

    /**
     * Konversi gambar ke WebP menggunakan GD.
     *
     * @return array{content: string}|null
     */
    protected function convertToWebp(UploadedFile $file): ?array
    {
        try {
            $realPath = $file->getRealPath();
            $mime = $file->getMimeType();

            $image = match ($mime) {
                'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
                'image/png' => @imagecreatefrompng($realPath),
                'image/webp' => @imagecreatefromwebp($realPath),
                default => null,
            };

            if (! $image) {
                return null;
            }

            // Pertahankan transparansi PNG jika ada
            if ($mime === 'image/png') {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }

            ob_start();
            imagewebp($image, null, 85); // Kualitas 85% optimal
            $content = ob_get_clean();
            imagedestroy($image);

            if (! $content) {
                return null;
            }

            return ['content' => $content];
        } catch (\Throwable) {
            return null;
        }
    }
}
