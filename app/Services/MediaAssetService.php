<?php

namespace App\Services;

use App\Models\MediaAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaAssetService
{
    /**
     * Upload dan simpan file ke media assets, dengan konversi otomatis gambar ke .webp.
     *
     * @param UploadedFile $file
     * @param string|null $altText
     * @param string $disk
     * @return MediaAsset
     */
    public function upload(UploadedFile $file, ?string $altText = null, string $disk = 'public'): MediaAsset
    {
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType() ?? 'application/octet-stream';
        $fileType = $this->determineFileType($mimeType);

        $year = date('Y');
        $month = date('m');
        $directory = "uploads/{$year}/{$month}";
        $slugName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));

        // Jika file berupa gambar dan bukan gif animasi, konversi ke .webp
        if ($fileType === 'image' && $mimeType !== 'image/gif' && function_exists('imagewebp')) {
            $converted = $this->convertToWebp($file);
            if ($converted !== null) {
                $fileName = "{$slugName}_" . Str::random(8) . ".webp";
                $filePath = "{$directory}/{$fileName}";

                Storage::disk($disk)->put($filePath, $converted['content']);
                $fileSizeKb = (int) ceil(strlen($converted['content']) / 1024);
                $mimeType = 'image/webp';

                return MediaAsset::create([
                    'file_path' => $filePath,
                    'file_name' => $originalName,
                    'file_type' => 'image',
                    'mime_type' => $mimeType,
                    'file_size_kb' => $fileSizeKb,
                    'alt_text' => $altText ?? pathinfo($originalName, PATHINFO_FILENAME),
                ]);
            }
        }

        // Simpan langsung jika bukan gambar atau konversi tidak berjalan
        $extension = $file->getClientOriginalExtension() ?: 'bin';
        $fileName = "{$slugName}_" . Str::random(8) . ".{$extension}";
        $filePath = Storage::disk($disk)->putFileAs($directory, $file, $fileName);
        $fileSizeKb = (int) ceil($file->getSize() / 1024);

        return MediaAsset::create([
            'file_path' => $filePath,
            'file_name' => $originalName,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size_kb' => $fileSizeKb,
            'alt_text' => $altText ?? pathinfo($originalName, PATHINFO_FILENAME),
        ]);
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
     * @param UploadedFile $file
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

            if (!$image) {
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

            if (!$content) {
                return null;
            }

            return ['content' => $content];
        } catch (\Throwable) {
            return null;
        }
    }
}
