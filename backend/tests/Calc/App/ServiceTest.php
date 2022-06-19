<?php

declare(strict_types=1);

namespace App\Tests\Calc\App;

use App\Calc\App\Service;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Request;

class ServiceTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient([], [
            'HTTP_HOST'       => 'web',
            'HTTP_USER_AGENT' => 'ApiTesting/1.0',
        ]);
    }

    public function testService(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 1,
            'numberB' => 2,
            'operation' => 'addition'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('3', $response->getContent());
    }

    public function testServiceNumberAException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 'one',
            'numberB' => 2,
            'operation' => 'addition'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Expected number in variable number A"', $response->getContent());
    }

    public function testServiceNumberANUllException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => null,
            'numberB' => 2,
            'operation' => 'addition'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Expected number in variable number A"', $response->getContent());
    }

    public function testServiceNumberBException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 1.564,
            'numberB' => 'two',
            'operation' => 'addition'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Expected number in variable number B"', $response->getContent());
    }

    public function testServiceNumberBNUllException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 5,
            'numberB' => null,
            'operation' => 'addition'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Expected number in variable number B"', $response->getContent());
    }

    public function testServiceNullOperationException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 1.564,
            'numberB' => 324.23,
            'operation' => null
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Wrong operation"', $response->getContent());
    }

    public function testServiceNonExistingOperationException(): void
    {
        $this->client->request('POST', '/calc/make', [
            'numberA' => 1.564,
            'numberB' => 324.23,
            'operation' => 'strangeDivision'
        ]);

        $response = $this->client->getResponse();

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('"Wrong operation"', $response->getContent());
    }

}
