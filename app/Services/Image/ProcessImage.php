<?php

namespace App\Services\Image;

use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use App\Domain\ValueObjects\ImageValueObject;
use Exception;
use Illuminate\Support\Facades\Log;

class ProcessImage
{
    private const DEFAULT_IMAGE_CONFIG = 'default_image';
    private const IMAGE_MAX_SIZE_CONFIG = 'image_max_size';

    public function __construct(
        private LocalStorageRepositoryInterface $localStorageRepository
    ) {}

    public function execute(?string $imageBase64, string $location, string $companyName, string $imageName, string $currentImagePath = null): string
    {
        if (empty($imageBase64)) {
            return $this->getDefaultImage($location);
        }

        try {
            if (!empty($currentImagePath)) {
                $this->deleteExistingImage($currentImagePath, $location);
            }

            $imagePath = $this->generateImagePath($imageBase64, $location, $companyName, $imageName);
            return $this->localStorageRepository->saveImage($imageBase64, $imagePath);
        } catch (Exception $e) {
            Log::info('Error processing image: ' . $e->getMessage());
            return $this->getDefaultImage($location);
        }
    }

    public function deleteExistingImage(string $currentImagePath, string $location): void
    {
        if (!empty($currentImagePath) && $currentImagePath !== config('image.' . $location . '.' . self::DEFAULT_IMAGE_CONFIG)) {
            $this->localStorageRepository->deleteImage($currentImagePath);
        }
    }

    private function generateImagePath(string $imageBase64, string $location, string $companyName, $imageName): string
    {
        $imageMaxSize = config('image.' . $location . '.' . self::IMAGE_MAX_SIZE_CONFIG);
        $imageName = str_replace(' ', '_', strtolower($imageName));

        $imageValueObject = new ImageValueObject($imageBase64, $imageMaxSize, $imageName);

        $mimeType = $imageValueObject->getMimeType();
        $myme = explode('/', $mimeType);

        return 'images/' . strtolower($companyName) . '/' . $location . '/' . $imageName . '.' . $myme[1];
    }

    private function getDefaultImage(string $location): string
    {
        return config('image.' . $location . '.' . self::DEFAULT_IMAGE_CONFIG);
    }
}
