<?php

namespace App\Application\Signup;

use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Exceptions\Signup\CreateCompanyAndAdminUserException;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Company\Company;
use App\Models\Scheduling\ScheduleSettings;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class CreateCompanyAndAdminUser
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private ScheduleSettingsRepositoryInterface  $scheduleSettingsRepositoryInterface,
        private JwtAuth $jwtAuth
    ) {}

    public function execute(CreateCompanyAndAdminUserRequestDTO $input): array
    {
        $this->validateInput($input);

        DB::beginTransaction();
        try {
            $company = $this->createCompany($input);
            $user = $this->createUser($input, $company);
            $this->createScheduleSettings($company, $input->getWorkSchedule());

            if (empty(config('jwtAuth.secret')) || empty(config('jwtAuth.domain') || empty(config('jwtAuth.expirationTime')))) {
                throw new CreateCompanyAndAdminUserException('Configuração JWT inválida: verifique se "secret", "domain" e "expirationTime" estão definidos.', 500);
            }

            $jwtToken = $this->jwtAuth->encode($user->id, config('jwtAuth.expirationTime'));

            DB::commit();

            return [
                'company' => $company,
                'token' => $jwtToken,
                'user' => $user
            ];
        } catch (UserException | CompanyException | ScheduleSettingsException $e) {
            DB::rollBack();
            throw new CreateCompanyAndAdminUserException($e->getMessage(), $e->getCode());
        }
    }

    private function validateInput(CreateCompanyAndAdminUserRequestDTO $input): void
    {
        if (empty($input->getFantasyName())) {
            throw new CompanyException('Nome fantasia é obrigatório', 400);
        }

        if (empty($input->getName())) {
            throw new UserException('Nome é obrigatório', 400);
        }

        if (empty($input->getEmail())) {
            throw new UserException('Email é obrigatório', 400);
        }

        if (empty($input->getPhoneNumber())) {
            throw new UserException('Telefone é obrigatório', 400);
        }

        if (empty($input->getPassword())) {
            throw new UserException('Senha é obrigatória', 400);
        }

        if (empty($input->getWorkSchedule())) {
            throw new ScheduleSettingsException('Horário de trabalho é obrigatório', 400);
        }
    }

    private function createCompany(CreateCompanyAndAdminUserRequestDTO $input): Company
    {
        $existingCompany = $this->companyRepositoryInterface->getByName($input->getFantasyName());
        if (!empty($existingCompany)) {
            throw new CompanyException('Uma empresa com este nome já existe', 400);
        }

        $newCompany = Company::new($input->getFantasyName());
        if (!$this->companyRepositoryInterface->save($newCompany)) {
            throw new CompanyException('Erro ao criar a empresa', 500);
        }

        $company = $this->companyRepositoryInterface->getByName($input->getFantasyName());

        return $company;
    }

    private function createUser(CreateCompanyAndAdminUserRequestDTO $input, Company $company): User
    {
        $existingUser = $this->userRepositoryInterface->getByEmail($input->getEmail());
        if (!empty($existingUser)) {
            throw new UserException('Email já cadastrado', 400);
        }

        $hashPassword = password_hash($input->getPassword(), PASSWORD_DEFAULT);

        $newUser = User::new(
            $company->id,
            $input->getName(),
            $input->getEmail(),
            $input->getPhoneNumber(),
            1,
            null,
            null,
            null,
            null,
            false,
            false,
            false,
            config('user.image.default_user_image'),
            $hashPassword,
            true
        );

        if (!$this->userRepositoryInterface->save($newUser)) {
            throw new UserException('Erro ao criar o usuário', 500);
        }

        $user = $this->userRepositoryInterface->getByEmail($input->getEmail());
        
        return $user;
    }

    private function createScheduleSettings(Company $company, array $workSchedule): void
    {
        $daysOfWeek = ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'];

        foreach ($workSchedule as $workDay) {
            if (!in_array($workDay['day'], $daysOfWeek)) {
                throw new ScheduleSettingsException('Dia de trabalho inválido.', 400);
            }

            $scheduleSettings = ScheduleSettings::new(
                $company->id,
                $workDay['day'],
                $workDay['start_time'],
                $workDay['end_time'],
                $workDay['is_working_day']
            );

            if (!$this->scheduleSettingsRepositoryInterface->save($scheduleSettings)) {
                throw new ScheduleSettingsException('Erro ao salvar configuração de agenda.', 500);
            }
        }
    }
}
