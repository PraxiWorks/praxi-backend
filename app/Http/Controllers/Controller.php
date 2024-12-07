<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $classe, $classCollection = null, $classResource = null;

    private function outputArrayToJson(string $type, array $data, int $code)
    {
        return response()->json(
            [
                'type' =>  $type,
                'data' =>  $data
            ],
            $code
        );
    }

    protected function outputSuccessArrayToJson($data, int $code)
    {

        if (empty($data)) {
            return response()->json(['type' =>  'success'], $code);
        }

        if (!empty($data['data'])) {
            $data['type'] = 'success';
            return $data;
        }

        return response()->json([
            'type' =>  'success',
            'data' =>  $data
        ], $code);
    }

    protected function outputErrorArrayToJson(string $mensagem, int $code)
    {
        return response()->json(
            [
                'type' =>  'error',
                'mensagem' => $mensagem
            ],
            $code
        );
    }
}
