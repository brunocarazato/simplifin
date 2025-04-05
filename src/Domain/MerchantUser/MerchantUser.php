<?php

declare(strict_types=1);

namespace App\Domain\MerchantUser;

use App\Domain\MerchantUser\Exception\MerchantUserCannotTransferException;
use App\Domain\User\User;

class MerchantUser extends User
{
    public function canTransfer(): bool
    {
        throw new MerchantUserCannotTransferException();
    }
}