<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer\Exception;

use Exception;

class ForbiddenTransferException extends Exception
{
    public $message = "Transfer not authorized.";
}
