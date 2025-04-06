<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Models\User as EloquentUser;
use PHP_CodeSniffer\Util\Common;
use App\Application\Factory\UserFactory;
use Illuminate\Database\Capsule\Manager as DB;

class EloquentUserRepository implements UserRepositoryInterface
{
    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function findById(int $id): User
    {
        $record = DB::table('users')->find($id);

        if (!$record) {
            throw new \Exception("User not found.");
        }

        return $this->userFactory->fromRecord($record);
    }

    public function save(User $user): void
    {
        $eloquent = EloquentUser::find($user->getId());

        if (!$eloquent) {
            $eloquent = new EloquentUser();
            $eloquent->id = $user->getId();
        }

        $eloquent->name = $user->getName();
        $eloquent->email = $user->getEmail();
        $eloquent->cpfCnpj = $user->getcpfCpnj();
        $eloquent->balance = $user->getBalance();
        $eloquent->save();
    }
}