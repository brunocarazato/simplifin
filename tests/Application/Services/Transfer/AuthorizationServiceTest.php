<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use App\Application\Services\Transfer\AuthorizationService;
use App\Application\Services\Transfer\CurlClient;

class AuthorizationServiceTest extends PHPUnit_TestCase
{
    public function testIsAuthorizedReturnsTrueWhenApiApproves()
    {
        $mockClient = $this->createMock(CurlClient::class);
        $mockClient->method('get')->willReturn(json_encode([
            'data' => [
                'authorization' => true
            ]
        ]));

        $service = new AuthorizationService($mockClient);
        $this->assertTrue($service->isAuthorized());
    }

    public function testIsAuthorizedReturnsFalseWhenApiRejects()
    {
        $mockClient = $this->createMock(CurlClient::class);
        $mockClient->method('get')->willReturn(json_encode([
            'data' => [
                'authorization' => false
            ]
        ]));

        $service = new AuthorizationService($mockClient);
        $this->assertFalse($service->isAuthorized());
    }

    public function testIsAuthorizedReturnsFalseOnCurlFailure()
    {
        $mockClient = $this->createMock(CurlClient::class);
        $mockClient->method('get')->willReturn(false);

        $service = new AuthorizationService($mockClient);
        $this->assertFalse($service->isAuthorized());
    }
}
