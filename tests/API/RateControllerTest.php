<?php

namespace Tests\API;

use App\Requests\API\CoinGeckoAPI;
use App\Services\EmailSubscriptionService;
use Tests\TestCase;

class RateControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinGeckoAPI = $this->createMock(CoinGeckoAPI::class);
        $this->app->instance(CoinGeckoAPI::class, $this->coinGeckoAPI);

        $this->emailSubscriptionService = app(EmailSubscriptionService::class);
    }

    /**
     * @test
     */
    public function it_successfully_returns_rate(): void
    {
        /* SETUP */
        $expectedCoinPrice = 12345.67;
        $this->coinGeckoAPI->method('getCoinPrice')
            ->willReturn($expectedCoinPrice);

        /* EXECUTE */
        $response = $this->getJson('/api/rate');

        /* ASSERT */
        $response->assertStatus(200)->assertJson([
            'rate' => $expectedCoinPrice,
        ]);
    }
}
