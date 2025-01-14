<?php

namespace App\Domain\Factories\Http;

use App\Domain\Enums\Http\HttpEnum;
use App\Infrastructure\Http\CurlHttp;

class HttpFactory
{
    public static function new(int $identificador): string{
        switch ($identificador) {            
            case HttpEnum::CURL_HTTP;
                return CurlHttp::class;
            default:
                return CurlHttp::class;                
        }
    }
}
