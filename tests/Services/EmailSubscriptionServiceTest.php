<?php

namespace Tests\Services;

use App\Exceptions\EmailAlreadyExistsException;
use App\Mail\SubscriptionMail;
use App\Requests\API\CoinGeckoAPI;
use App\Services\EmailSubscriptionService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailSubscriptionServiceTest extends TestCase
{
    private EmailSubscriptionService $emailSubscriptionService;

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
    public function it_successfully_subscribes_email()
    {
        /* SETUP */
        $email = $this->faker->email;

        /* EXECUTE */
        $this->emailSubscriptionService->subscribe($email);

        /* ASSERT */
        $this->assertDatabaseHas('user', [
            'email' => $email
        ]);
    }

    /**
     * @test
     */
    public function it_throws_exception_for_existing_email()
    {
        /* SETUP */
        $email = $this->faker->email;

        $this->emailSubscriptionService->subscribe($email);

        /* ASSERT */
        $this->expectException(EmailAlreadyExistsException::class);

        /* EXECUTE */
        $this->emailSubscriptionService->subscribe($email);
    }

    /**
     * @test
     */
    public function it_sends_emails()
    {
        /* SETUP */
        Mail::fake();

        $this->emailSubscriptionService->subscribe($this->faker->email);
        $this->emailSubscriptionService->subscribe($this->faker->email);

        $expectedCoinPrice = 12345.67;
        $this->coinGeckoAPI->method('getCoinPrice')
            ->willReturn($expectedCoinPrice);

        /* EXECUTE */
        $this->emailSubscriptionService->sendEmails();

        /* ASSERT */
        Mail::assertSent(SubscriptionMail::class, 2);
    }
}
