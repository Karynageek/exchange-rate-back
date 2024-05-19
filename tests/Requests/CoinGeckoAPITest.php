<?php

namespace Tests\Requests;

use App\Exceptions\CoinPriceNotFoundException;
use App\Requests\API\CoinGeckoAPI;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CoinGeckoAPITest extends TestCase
{
    private CoinGeckoAPI $coinGeckoAPI;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coinGeckoAPI = new CoinGeckoAPI();
    }

    /**
     * @test
     */
    public function it_successfully_returns_coin_price(): void
    {
        /* SETUP */
        $from = 'bitcoin';
        $to = 'uah';

        $expectedCoinPrice = 2612690.0;

        $mockedResponse = new Response(
            200,
            [],
            json_encode([$from => [$to => $expectedCoinPrice]])
        );

        $mockedClient = $this->createMock(Client::class);
        $mockedClient->expects($this->once())
            ->method('get')
            ->withAnyParameters()
            ->willReturn($mockedResponse);

        $reflection = new ReflectionClass($this->coinGeckoAPI);
        $reflectionProperty = $reflection->getProperty('client');
        $reflectionProperty->setValue($this->coinGeckoAPI, $mockedClient);

        /* EXECUTE */
        $coinPrice = $this->coinGeckoAPI->getCoinPrice();

        /* ASSERT */
        $this->assertEquals($expectedCoinPrice, $coinPrice);
    }

    /**
     * @test
     */
    public function it_throws_exception_when_request_fails(): void
    {
        /* SETUP */
        $from = 'bitcoin';

        $mockedClient = $this->createMock(Client::class);
        $mockedClient->expects($this->once())
            ->method('get')
            ->willThrowException(new RequestException("Error", new Request('GET', 'dummy-url')));

        $reflection = new ReflectionClass($this->coinGeckoAPI);
        $reflectionProperty = $reflection->getProperty('client');
        $reflectionProperty->setValue($this->coinGeckoAPI, $mockedClient);

        /* ASSERT */
        $this->expectException(GuzzleException::class);

        /* EXECUTE */
        $this->coinGeckoAPI->getCoinPrice($from);
    }

    /**
     * @test
     */
    public function it_throws_exception_when_coin_price_not_found(): void
    {
        /* SETUP */
        $mockedResponse = new Response(
            200,
            [],
            json_encode([])
        );

        $mockedClient = $this->createMock(Client::class);
        $mockedClient->expects($this->once())
            ->method('get')
            ->withAnyParameters()
            ->willReturn($mockedResponse);

        $reflection = new ReflectionClass($this->coinGeckoAPI);
        $reflectionProperty = $reflection->getProperty('client');
        $reflectionProperty->setValue($this->coinGeckoAPI, $mockedClient);

        /* ASSERT */
        $this->expectException(CoinPriceNotFoundException::class);

        /* EXECUTE */
        $this->coinGeckoAPI->getCoinPrice();
    }
}
