<?php

namespace App\Service;

use App\Security\User;

interface LoginProviderInterface
{
    public function attemptLogin(string $email, string $password): ?User;
}