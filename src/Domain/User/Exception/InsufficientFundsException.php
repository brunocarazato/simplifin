<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Domain\DomainException\DomainException;

class InsufficientFundsException extends DomainException
{
    public $message = 'Insufficient Funds.';
}
