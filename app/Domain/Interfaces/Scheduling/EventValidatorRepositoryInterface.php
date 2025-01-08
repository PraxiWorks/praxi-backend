<?php

namespace App\Domain\Interfaces\Scheduling;

interface EventValidatorRepositoryInterface
{
    public function validate($input): void;
}