<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class ImageValueObject
{
    private string $base64String;
    private string $mimeType;

    private const VALID_MIME_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];

    public function __construct(string $base64String, float $tamanhoMaximoMb)
    {
        $this->isValidImage($base64String, $tamanhoMaximoMb);
        $this->base64String = $base64String;        
    }

    private function isValidImage(string $base64String, float $tamanhoMaximoMb): void
    {
        if (empty($base64String)) {
            throw new InvalidArgumentException('A imagem não pode estar vazia.', 400);
        }

        $imageData = base64_decode($base64String, true);
        if ($imageData === false) {
            throw new InvalidArgumentException('Formato base64 inválido. Certifique-se de que é uma imagem.', 400);
        }

        if (!$this->validateSize($imageData, $tamanhoMaximoMb)) {
            $imageSizeBytes = strlen($imageData);
            throw new InvalidArgumentException(sprintf(
                'A imagem excede o tamanho máximo permitido de %d MB. Tamanho atual: %.2f MB.',
                $tamanhoMaximoMb,
                $imageSizeBytes / (1024 * 1024)
            ), 400);
        }

        $this->setMimeType($imageData);

        if (!$this->validateMimeType($imageData)) {
            throw new InvalidArgumentException('Tipo MIME da imagem inválido. Permitidos: JPEG, PNG, GIF.', 400);
        }
    }

    private function validateSize(string $imageData, float $maxFileSizeMb): bool
    {
        $imageSizeBytes = strlen($imageData);
        $maxFileSizeBytes = $maxFileSizeMb * 1024 * 1024;
        return $imageSizeBytes <= $maxFileSizeBytes;
    }

    private function setMimeType(string $imageData): void
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $this->mimeType = $finfo->buffer($imageData) ?? $this->getMimeTypeFallback($imageData);
    }

    private function validateMimeType(string $imageData): bool
    {
        $mimeType = $this->getMimeType($imageData);
        return in_array($mimeType, self::VALID_MIME_TYPES, true);
    }

    private function getMimeTypeFallback(string $imageData): ?string
    {
        $imageInfo = getimagesizefromstring($imageData);
        return $imageInfo['mime'] ?? null;
    }

    public function getValue(): string
    {
        return $this->base64String;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
