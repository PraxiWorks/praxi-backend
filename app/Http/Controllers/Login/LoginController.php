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

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $input = new LoginRequestDTO($username, $password);
            $output = $this->useCase->execute($input);
            return $this->outputSuccessArrayToJson($output->toArray(), 200);
        } catch (Exception $e) {
            dd($e);
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
