<?php

namespace App\Infrastructure\Storage;

use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

class LocalStorageRepository implements LocalStorageRepositoryInterface
{
    public function saveImage(string $base64EncodedImage, string $destinationPath): string
    {
        try {
            Storage::disk('public')->put($destinationPath, base64_decode($base64EncodedImage));
            if (Storage::disk('public')->exists($destinationPath)) {
                return $destinationPath;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function getImage(string $filePath): ?string
    {
        try {
            return Storage::disk('public')->get($filePath);
        } catch (Exception $e) {
            return null;
        }
    }

    public function deleteImage(string $filePath): bool
    {
        try {
            Storage::disk('public')->delete($filePath);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
