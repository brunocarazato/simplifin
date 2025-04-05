<?php

declare(strict_types=1);

namespace App\Domain\CommonUser;

use App\Domain\User\User;

class CommonUser extends User
{

    public function canTransfer(): bool
    {      
        return true;
    }

}
