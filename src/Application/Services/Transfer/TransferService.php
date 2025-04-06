<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer;

use App\Domain\User\User;
use App\Application\Services\Transfer\Exception\ForbiddenTransferException;
use Illuminate\Database\Capsule\Manager as DB;
use App\Domain\User\UserRepositoryInterface;

class TransferService
{
    public function __construct(
        private AuthorizationService $authorizationService,
        private NotificationService $notificationService,
        private UserRepositoryInterface $userRepository
    ) {}

    public function transfer(User $payer, User $payee, float $amount): void
    {

        DB::transaction(function () use ($payer, $payee, $amount) {
            $payer->canTransfer();
    
            if (!$this->authorizationService->isAuthorized()) {
                throw new ForbiddenTransferException();
            }
    
            $payer->debit($amount); 
            $payee->credit($amount);
    
            $this->userRepository->save($payer);
            $this->userRepository->save($payee);
    
            $this->notificationService->notify($payee);
        });
    }
}