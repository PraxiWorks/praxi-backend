<?php

namespace App\Application\DTO;

class OutputArrayDTO
{
    private array $dados;
   
    public function __construct(array $dados)
    {
       $this->dados = $dados;
    }
 
    public function toArray() 
    {
       return $this->dados;
    } 
}