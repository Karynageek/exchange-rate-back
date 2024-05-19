<?php

namespace Tests\API;

use App\Requests\API\CoinGeckoAPI;
use App\Services\EmailSubscriptionService;
use Tests\TestCase;

class EmailSubscriptionControllerTest extends TestCase
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
    public function it_successfully_subscribes_user_to_email_subscription(): void
    {
        /* SETUP */
        $email = $this->faker->email;

        /* EXECUTE */
        $response = $this->postJson('/api/subscribe', ['email' => $email]);

        /* ASSERT */
        $response->assertStatus(200)->assertJson(['message' => 'Email subscribed']);
    }

    /**
     * @test
     */
    public function it_fails_to_subscribe_user_to_email_subscription_if_email_already_exists(): void
    {
        /* SETUP */
        $email = $this->faker->email;
        $this->postJson('/api/subscribe', ['email' => $email]);

        /* EXECUTE */
        $response = $this->postJson('/api/subscribe', ['email' => $email]);

        /* ASSERT */
        $response->assertStatus(400)->assertJson(['message' => 'Email already exists!']);
    }

    /**
     * @test
     */
    public function it_sends_email_to_subscribed_user(): void
    {
        /* SETUP */
        $email = $this->faker->email;
        $this->postJson('/api/subscribe', ['email' => $email]);

        $expectedCoinPrice = 12345.67;
        $this->coinGeckoAPI->method('getCoinPrice')
            ->willReturn($expectedCoinPrice);

        /* EXECUTE */
        $response = $this->postJson('/api/send-emails');

        /* ASSERT */
        $response->assertStatus(200)->assertJson(['message' => 'Emails sent']);
    }
}
