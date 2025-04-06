<?php

declare(strict_types=1);

namespace App\Application\Actions\Transfer;

use App\Application\Actions\Action;
use App\Application\Services\Transfer\TransferService;
use App\Domain\User\UserRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TransferAction extends Action
{
    public function __construct(
        private TransferService $transferService,
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    protected function action(): Response
    {
        $data = (array) $this->request->getParsedBody();

        $value = (float) $data['value'];
        $payerId = (int) $data['payer'];
        $payeeId = (int) $data['payee'];

        $payer = $this->userRepositoryInterface->findById($payerId);
        $payee = $this->userRepositoryInterface->findById($payeeId);

        $this->transferService->transfer($payer, $payee, $value);

        return $this->respondWithData(['message' => 'Transfer successful']);
    }
}
