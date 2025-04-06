<?php
namespace App\Application\Factory;
use App\Domain\CommonUser\CommonUser;
use App\Domain\MerchantUser\MerchantUser;
use App\Domain\User\User;
use App\Infrastructure\Models\User as UserModel;


class UserFactory
{
    public static function fromRecord(object $record): User
    {
         if ($record->type === 'merchant') {
            return new MerchantUser(
                $record->id,
                $record->name,
                $record->email,
                $record->balance
            );
        }

        return new CommonUser(
            $record->id,
            $record->name,
            $record->email,
            $record->balance
        );
    }
}
