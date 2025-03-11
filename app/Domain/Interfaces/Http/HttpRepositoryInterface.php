<?php

namespace App\Domain\Interfaces\Http;

interface HttpRepositoryInterface
{
    public function __construct(string $urlBase = '');
    public function post(string $url, array $dados = []);
    public function put(string $url, array $dados = []);
    public function patch(string $url, array $dados = []);
    public function get(string $url);
    public function addHeaders(array $header): void;
    public function setUrl(string $url): void;
}
