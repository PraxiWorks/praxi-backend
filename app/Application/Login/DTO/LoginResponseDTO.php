<?php

namespace App\Application\Login\DTO;

class LoginResponseDTO
{
   public function __construct(
      private string $token,
   ) {}

   public function toArray(): array
   {
      return [
         'token' => $this->token
      ];
   }
}
