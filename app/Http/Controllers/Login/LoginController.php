<?php

namespace App\Http\Controllers\Login;

use App\Application\Login\DTO\LoginRequestDTO;
use App\Application\Login\Login;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct(private Login $useCase) {}

    public function store(Request $request)
    {
        $empresaId = $request->input('empresaId');
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $input = new LoginRequestDTO($empresaId, $email, $password);
            $output = $this->useCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
