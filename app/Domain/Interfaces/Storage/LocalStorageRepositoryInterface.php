<?php

namespace App\Domain\Interfaces\Storage;

interface LocalStorageRepositoryInterface
{
    public function saveImage(string $base64EncodedImage, string $destinationPath): string;
    public function getImage(string $filePath): ?string;
    public function deleteImage(string $filePath): bool;
}
