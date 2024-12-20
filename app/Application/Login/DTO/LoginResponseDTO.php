<?php

namespace App\Application\Login\DTO;

class LoginResponseDTO 
{
    private string $token;

    public function __construct(string $token) 
    {
         $this->token = $token;
    }
    
    public function toArray():array
   {
      return [
         'token' => $this->token
      ];
   }
}
