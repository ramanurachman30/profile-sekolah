<?php

namespace App\Filament\Resources\MediaAssets\Pages;

use App\Filament\Resources\MediaAssets\MediaAssetResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMediaAsset extends CreateRecord
{
    protected static string $resource = MediaAssetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['file_path'])) {
            $disk = Storage::disk('public');
            $fullPath = $disk->path($data['file_path']);

            if (empty($data['file_name'])) {
                $data['file_name'] = basename($data['file_path']);
            }

            if (file_exists($fullPath)) {
                $data['file_size_kb'] = (int) ceil(filesize($fullPath) / 1024);
                $mime = mime_content_type($fullPath) ?: 'application/octet-stream';
                $data['mime_type'] = $mime;
                $data['file_type'] = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : 'document');
            } else {
                $data['file_size_kb'] = $data['file_size_kb'] ?? 100;
                $data['mime_type'] = $data['mime_type'] ?? 'image/webp';
                $data['file_type'] = $data['file_type'] ?? 'image';
            }
        }

        return $data;
    }
}
