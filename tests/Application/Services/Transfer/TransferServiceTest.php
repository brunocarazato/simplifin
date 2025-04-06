<?php

use PHPUnit\Framework\TestCase;
use App\Application\Services\Transfer\TransferService;
use App\Application\Services\Transfer\AuthorizationService;
use App\Application\Services\Transfer\NotificationService;
use App\Domain\CommonUser\CommonUser;
use App\Domain\MerchantUser\MerchantUser;
use App\Domain\User\User;
use App\Domain\MerchantUser\Exception\MerchantUserCannotTransferException;  

class TransferServiceTest extends TestCase
{
    public function testTransferSuccessful()
    {
  
        $payer = $this->createMock(User::class);
        $payee = $this->createMock(User::class);

        $payer->expects($this->once())->method('canTransfer');
        $payer->expects($this->once())->method('debit')->with(100.0);
        $payee->expects($this->once())->method('credit')->with(100.0);

        $authService = $this->createMock(AuthorizationService::class);
        $authService->method('isAuthorized')->willReturn(true);

        $notificationService = $this->createMock(NotificationService::class);
        $notificationService->expects($this->once())->method('notify')->with($payee);

        $transferService = new TransferService($authService, $notificationService);

        $transferService->transfer($payer, $payee, 100.0);

        $this->assertTrue(true);
    }

    public function testTransferFailsIfUnauthorized()
    {
        $this->expectException(Exception::class);
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

        $transferService = new TransferService($authService, $notificationService);
        $transferService->transfer($payer, $payee, 100.0);
    }

    public function testTransferFailsIfPayerIsMerchant()
    {
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

        $transferService = new TransferService($authService, $notificationService);
        $transferService->transfer($payer, $payee, 100.0);

    }
}
