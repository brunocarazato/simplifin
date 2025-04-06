<?php

use PHPUnit\Framework\TestCase;
use App\Application\Services\Transfer\TransferService;
use App\Application\Services\Transfer\AuthorizationService;
use App\Application\Services\Transfer\NotificationService;
use App\Domain\CommonUser\CommonUser;
use App\Domain\MerchantUser\MerchantUser;
use App\Domain\User\User;
use App\Domain\MerchantUser\Exception\MerchantUserCannotTransferException;  
use App\Domain\User\UserRepositoryInterface;
use App\Application\Services\Transfer\Exception\ForbiddenTransferException;
class TransferServiceTest extends TestCase
{
    /**
     * @ignore
     */
    public function testTransferSuccessful()
    {
        $this->markTestSkipped('Ignorado temporariamente porque usa DB::transaction');
        $payer = $this->createMock(CommonUser::class);
        $payee = $this->createMock(CommonUser::class);

        $payer->expects($this->once())->method('canTransfer');
        $payer->expects($this->once())->method('debit')->with(100.0);
        $payee->expects($this->once())->method('credit')->with(100.0);

        $authService = $this->createMock(AuthorizationService::class);
        $authService->method('isAuthorized')->willReturn(true);

        $notificationService = $this->createMock(NotificationService::class);
        $notificationService->expects($this->once())->method('notify')->with($payee);

        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $transferService = new TransferService($authService, $notificationService, $userRepository);

        $transferService->transfer($payer, $payee, 100.0);

    }

    
    public function testTransferFailsIfUnauthorized()
    {
        $this->markTestSkipped('Ignorado temporariamente porque usa DB::transaction');
        $this->expectException(ForbiddenTransferException::class);
        $this->expectExceptionMessage('Transfer not authorized');

        $payer = $this->createMock(User::class);
        $payee = $this->createMock(User::class);

        $payer->method('canTransfer');
        $payer->expects($this->never())->method('debit');
        $payee->expects($this->never())->method('credit');

        $authService = $this->createMock(AuthorizationService::class);
        $authService->method('isAuthorized')->willReturn(false);

        $notificationService = $this->createMock(NotificationService::class);
        $notificationService->expects($this->never())->method('notify');
        
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $transferService = new TransferService($authService, $notificationService, $userRepository);
        $transferService->transfer($payer, $payee, 100.0);
    }

    public function testTransferFailsIfPayerIsMerchant()
    {
        $this->markTestSkipped('Ignorado temporariamente porque usa DB::transaction');
        $this->expectException(MerchantUserCannotTransferException::class);
        $this->expectExceptionMessage('Merchants can\'t transfer.');

        $payer = $this->createMock(MerchantUser::class);
        $payee = $this->createMock(CommonUser::class);

        $payer->method('canTransfer')
        ->willThrowException(new MerchantUserCannotTransferException("Merchants can't transfer."));

        $payer->expects($this->never())->method('debit');
        $payee->expects($this->never())->method('credit');

        $authService = $this->createMock(AuthorizationService::class);
        $authService->expects($this->never())->method('isAuthorized');


        $notificationService = $this->createMock(NotificationService::class);
        $notificationService->expects($this->never())->method('notify');

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $transferService = new TransferService($authService, $notificationService, $userRepository);
        $transferService->transfer($payer, $payee, 100.0);

    }
}
