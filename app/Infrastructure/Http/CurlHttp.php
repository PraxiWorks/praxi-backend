<?php

namespace App\Infrastructure\Http;

use App\Domain\Interfaces\Http\HttpRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CurlHttp implements HttpRepositoryInterface

{
    private string $urlBase;
    private array $headers;

    public function __construct(string $urlBase = '')
    {
        $this->urlBase = $urlBase;
        $this->headers = [];
    }

    public function post(string $url, array $dados = [])
    {
        return $this->curl('POST', $url, $dados);
    }

    public function put(string $url, array $dados = [])
    {
        return $this->curl('PUT', $url, $dados);
    }

    public function patch(string $url, array $dados = [])
    {
        return $this->curl('PATCH', $url, $dados);
    }

    public function get(string $url)
    {
        return $this->curl('GET', $url);
    }

    public function setUrl(string $url): void
    {
        $this->urlBase = $url;
    }

    public function addHeaders(array $headers): void
    {
        foreach ($headers as $header) {
            $this->headers[] = $header;
        }
    }

    private function curl(string $metodo, string $url, array $dados = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $this->urlBase . '' . $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            $this->headers
        );

        if (!empty($dados)) {
            if (in_array('Content-Type: application/x-www-form-urlencoded', $this->headers)) {
                $dados = http_build_query($dados);
            } else {
                $dados = json_encode($dados);
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        }

        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        $data = curl_exec($ch);
        dd($data);

        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $data = 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        $retorno['data'] = json_decode($data, true);
        $retorno['statusCode'] = $info;
        if ($this->isLogEnabled()) {
            Log::debug("REQUEST=>" . json_encode($dados) . PHP_EOL . PHP_EOL . "RESPONSE=>" . $data);
        }
        return $retorno;
    }


    private function isLogEnabled(): bool
    {
        return env('CURL_HTTP_LOG_ENABLE');
    }
}
