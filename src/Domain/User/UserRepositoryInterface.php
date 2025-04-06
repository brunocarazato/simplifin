<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function findById(int $id): User;
    public function save(User $user): void;
}
