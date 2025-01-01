<?php

namespace App\Http\Controllers\Signup;

use App\Application\Signup\CreateCompanyAndAdminUser;
use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SignupController extends Controller
{

    public function __construct(private CreateCompanyAndAdminUser $useCase) {}

    public function store(Request $request)
    {
        $planId = $request->input('plan_id') ?? 0;
        $modules = $request->input('modules') ?? [];
        $fantasyName = $request->input('fantasy_name') ?? '';
        $username = $request->input('username') ?? '';
        $name = $request->input('name') ?? '';
        $email = $request->input('email') ?? '';
        $phoneNumber = $request->input('phone_number') ?? '';
        $password = $request->input('password') ?? '';
        $workSchedule = $request->input('days') ?? [];

        try {
            $input = new CreateCompanyAndAdminUserRequestDTO(
                $planId,
                $modules,
                $fantasyName,
                $username,
                $name,
                $email,
                $phoneNumber,
                $password,
                $workSchedule
            );
            $output = $this->useCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
