<?php

declare(strict_types=1);

namespace App\Domain\MerchantUser\Exception;

use App\Domain\DomainException\DomainException;

class MerchantUserCannotTransferException extends DomainException {
    public $message = 'Merchants can\'t transfer.';
}