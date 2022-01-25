<?php

namespace App\Tests\Data;

use BaseTest;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UserAddressTest extends BaseTest
{
    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testUserAddress(): void
    {
        $this->setHttpPath('/api/user/address');
        self::assertJsonMatchesSchema(
            $this->getResponse(),
            $this->getScheme('UserAddress.json')
        );

    }
}
