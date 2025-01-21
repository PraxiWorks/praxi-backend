<?php

namespace App\Application\Signup;

use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use App\Domain\Exceptions\Core\Company\CompanyException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Exceptions\Signup\CreateCompanyAndAdminUserException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Core\Company\Company;
use App\Models\Core\Company\CompanyModule;
use App\Models\Core\Company\CompanyPlan;
use App\Models\Core\Permission\GroupPermission;
use App\Models\Core\Plan\Plan;
use App\Models\Scheduling\ScheduleSettings;
use App\Models\Register\User\User;
use App\Models\Settings\Group\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateCompanyAndAdminUser
{
    public function __construct(
        private PlanRepositoryInterface $planRepositoryInterface,
        private PlanModuleRepositoryInterface $planModuleRepositoryInterface,
        private ModuleRepositoryInterface $moduleRepositoryInterface,
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private CompanyPlanRepositoryInterface $companyPlanRepositoryInterface,
        private CompanyModuleRepositoryInterface $companyModuleRepositoryInterface,
        private GroupRepositoryInterface $groupRepositoryInterface,
        private ModulePermissionRepositoryInterface $modulePermissionRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface,
        private JwtAuth $jwtAuth
    ) {}

    public function execute(CreateCompanyAndAdminUserRequestDTO $input): array
    {
        $this->validateInput($input);

        DB::beginTransaction();
        try {
            $plan = !empty($input->getPlanId()) ? $this->getPlan($input->getPlanId()) : null;
            $moduleIds = $this->getModuleIds($input, $plan);
            $company = $this->createCompany($input, $plan, $moduleIds);
            $group = $this->createGroup($company, $moduleIds);
            $user = $this->createUser($input, $company, $group);
            $this->createScheduleSettings($company, $input->getWorkSchedule());
            $jwtToken = $this->generateJwtToken($user);

            DB::commit();

            return [
                'company' => $company,
                'token' => $jwtToken,
                'user' => $user
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw new CreateCompanyAndAdminUserException($e->getMessage(), $e->getCode());
        }
    }


    private function validateInput(CreateCompanyAndAdminUserRequestDTO $input): void
    {
        $requiredFields = [
            'Nome fantasia' => $input->getFantasyName(),
            'Username' => $input->getUsername(),
            'Nome' => $input->getName(),
            'Email' => $input->getEmail(),
            'Telefone' => $input->getPhoneNumber(),
            'Senha' => $input->getPassword(),
            'Horário de trabalho' => $input->getWorkSchedule(),
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                throw new CreateCompanyAndAdminUserException("{$field} é obrigatório", 400);
            }
        }

        // Validação específica para plano e módulos
        if (empty($input->getPlanId()) && empty($input->getModules())) {
            throw new CreateCompanyAndAdminUserException('É necessário informar pelo menos um plano ou módulo.', 400);
        }
    }


    private function getPlan(int $planId): Plan
    {
        $plan = $this->planRepositoryInterface->getById($planId);
        if (empty($plan)) {
            throw new CreateCompanyAndAdminUserException('Plano não encontrado', 404);
        }
        return $plan;
    }

    private function getModuleIds(CreateCompanyAndAdminUserRequestDTO $input, ?Plan $plan): array
    {
        $moduleIds = [];
        if (!empty($plan)) {
            $planModules = $this->planModuleRepositoryInterface->getByPlanId($plan->id);
            foreach ($planModules as $planModule) {
                $moduleIds[] = $planModule->module_id;
            }
        }

        if (!empty($input->getModules())) {
            foreach ($input->getModules() as $moduleId) {
                $module = $this->moduleRepositoryInterface->getById($moduleId);
                if (empty($module)) {
                    throw new CreateCompanyAndAdminUserException('Módulo não encontrado', 404);
                }
                $moduleIds[] = $module->id;
            }
        }

        return array_unique($moduleIds);
    }


    private function createCompany(CreateCompanyAndAdminUserRequestDTO $input, ?Plan $plan, array $moduleIds): Company
    {

        $existingCompany = $this->companyRepositoryInterface->getByName($input->getFantasyName());
        if (!empty($existingCompany)) {
            throw new CompanyException('Uma empresa com este nome já existe', 400);
        }

        $start_trial = null;
        $end_trial = null;

        if (!empty($plan)) {
            if ($plan->name === 'Plano Gratuito') {
                $start_trial = date('Y-m-d H:i:s');
                $end_trial = date('Y-m-d H:i:s', strtotime('+' . $plan->duration_days . ' days'));
            }
        }

        $company = Company::new(
            $input->getFantasyName(),
            $start_trial,
            $end_trial
        );

        if (!$this->companyRepositoryInterface->save($company)) {
            throw new CompanyException('Erro ao criar a empresa', 500);
        }

        if (!empty($plan)) {
            $companyPlan = CompanyPlan::new($company->id, $plan->id);
            if (!$this->companyPlanRepositoryInterface->save($companyPlan)) {
                throw new CreateCompanyAndAdminUserException('Erro ao salvar o plano na empresa', 500);
            };
        }

        if (!empty($moduleIds)) {
            foreach ($moduleIds as $moduleId) {
                $companyModule = CompanyModule::new($company->id, $moduleId);
                if (!$this->companyModuleRepositoryInterface->save($companyModule)) {
                    throw new CreateCompanyAndAdminUserException('Erro ao salvar o módulo na empresa', 500);
                }
            }
        }

        return $company;
    }

    private function createGroup(Company $company, array $moduleIds): Group
    {
        $group = Group::new(
            $company->id,
            'Administrador',
            true
        );

        if (!$this->groupRepositoryInterface->save($group)) {
            throw new CreateCompanyAndAdminUserException('Erro ao criar o grupo', 500);
        };

        $permissions = $this->modulePermissionRepositoryInterface->getPermissionsByList($moduleIds);

        foreach ($permissions as $permission) {
            $groupPermission = GroupPermission::new(
                $group->id,
                $permission->id,
                false
            );

            if (!$this->groupPermissionRepositoryInterface->save($groupPermission)) {
                throw new CreateCompanyAndAdminUserException('Erro ao atribuir as permissões ao grupo', 500);
            }
        }

        return $group;
    }

    private function createUser(CreateCompanyAndAdminUserRequestDTO $input, Company $company, Group $group): User
    {
        $existingEmail = $this->userRepositoryInterface->getByEmailAndCompanyId($input->getEmail(), $company->id);
        if (!empty($existingEmail)) {
            throw new UserException('Email já cadastrado', 400);
        }

        $existingUsername = $this->userRepositoryInterface->getByUsername($input->getUsername());
        if (!empty($existingUsername)) {
            throw new UserException('Nome de usuário já cadastrado', 400);
        }

        $hashPassword = Hash::make($input->getPassword());

        $user = User::new(
            $company->id,
            $input->getUsername(),
            $input->getName(),
            $input->getEmail(),
            $input->getPhoneNumber(),
            null,
            null,
            null,
            null,
            false,
            false,
            false,
            config('image.users.default_image'),
            $hashPassword,
            true,
            $group->id,
            true
        );

        if (!$this->userRepositoryInterface->save($user)) {
            throw new UserException('Erro ao criar o usuário', 500);
        }

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

    private function generateJwtToken(User $user): string
    {
        if (empty(config('jwtAuth.secret')) || empty(config('jwtAuth.domain')) || empty(config('jwtAuth.expirationTime'))) {
            throw new CreateCompanyAndAdminUserException('Configuração JWT inválida: verifique se "secret", "domain" e "expirationTime" estão definidos.', 500);
        }

        $data = [
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ];

        return $this->jwtAuth->encode($data, config('jwtAuth.expirationTime'));
    }
}
