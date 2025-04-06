<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer;

use App\Domain\User\User;

class NotificationService
{
    public function __construct(
        private CurlClient $client
    ) {}

    public function notify(User $user): void
    {
        $this->client->post('https://util.devi.tools/api/v1/notify', [
            'email' => $user->getEmail(),
            'message' => 'Você recebeu uma transferência!'
        ]);
    }
}
