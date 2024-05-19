<?php

namespace App\Services;

use App\Exceptions\EmailAlreadyExistsException;
use App\Models\User;
use App\Repos\User\UserRepo;
use App\Requests\API\CoinGeckoAPI;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionMail;

class EmailSubscriptionService
{
    const CHUNK_SIZE = 100;

    public function __construct(protected UserRepo $userRepo, protected CoinGeckoAPI $coinGeckoAPI)
    {
    }

    /**
     * Check if email already exists
     *
     * @param string $email
     * @throws EmailAlreadyExistsException
     */
    public function checkEmailExists(string $email): void
    {
        if ($this->userRepo->firstByOrNull('email', $email)) {
            throw new EmailAlreadyExistsException('Email already exists!');
        }
    }

    /**
     * Subscribe a user to receive the e-mails.
     *
     * @param string $email
     * @throws EmailAlreadyExistsException
     */
    public function subscribe(string $email): void
    {
        $this->checkEmailExists($email);

        $this->userRepo->create([
            'email' => $email,
        ]);
    }

    /**
     * Send an e-mail to all subscribed users.
     */
    public function sendEmails(): void
    {
        $coinPrice = $this->coinGeckoAPI->getCoinPrice();

        $this->userRepo->chunkAll(self::CHUNK_SIZE, function (Collection $users) use ($coinPrice) {
            $users->each(function (User $user) use ($coinPrice){
                Mail::to($user->email)->send(new SubscriptionMail($coinPrice));
            });
        });
    }
}
