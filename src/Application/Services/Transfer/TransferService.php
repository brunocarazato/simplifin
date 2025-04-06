<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer;

use App\Domain\User\User;
use App\Application\Services\Transfer\Exception\ForbiddenTransferException;

class TransferService
{
    public function __construct(
        private AuthorizationService $authorizationService,
        private NotificationService $notificationService
    ) {}

    public function transfer(User $payer, User $payee, float $amount): void
    {

        $payer->canTransfer();

        if (!$this->authorizationService->isAuthorized()) {
            throw new ForbiddenTransferException();
        }

        $payer->debit($amount);
        $payee->credit($amount);

        $this->notificationService->notify($payee);
    }
}