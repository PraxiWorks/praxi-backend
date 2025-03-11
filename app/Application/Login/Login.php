<?php

namespace App\Application\Login;

use App\Application\Login\DTO\LoginRequestDTO;
use App\Application\Login\DTO\LoginResponseDTO;
use App\Domain\Exceptions\Login\LoginException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;

class Login
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private StripeSubscriptionRepositoryInterface $stripeSubscriptionRepositoryInterface,
        private JwtAuth $jwtAuth
    ) {}

    public function execute(LoginRequestDTO $input): LoginResponseDTO
    {
        $this->validateInput($input);

        $user = $this->userRepositoryInterface->getByUsername($input->getUsername());
        if (empty($user)) {
            throw new UserNotFoundException('Usuário não encontrado', 404);
        }

        $company = $this->companyRepositoryInterface->getById($user->company_id);

        if (!password_verify($input->getPassword(), $user->password)) {
            throw new UserException('Senha inválida', 400);
        }

        $subscription = $this->stripeSubscriptionRepositoryInterface->getByCompanyId($user->company_id);

        $data = [
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'group_id' => $user->group_id,
            'subscription_id' => $subscription ? $subscription->id : null,
            'subscription_status' => $subscription ? $subscription->status : null,
        ];

        if (!empty($company->end_trial)) {
            $data['end_trial'] = $company->end_trial;
        }

        $jwtToken = $this->jwtAuth->encode($data, config('jwtAuth.expirationTime'));

        return new LoginResponseDTO($jwtToken);
    }

    private function validateInput(LoginRequestDTO $input): void
    {
        if (empty($input->getUsername())) {
            throw new LoginException('Nome de usuário não informado', 400);
        }

        if (empty($input->getPassword())) {
            throw new LoginException('Senha não informada', 400);
        }
    }
}
