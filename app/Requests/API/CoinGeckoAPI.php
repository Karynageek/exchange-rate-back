<?php

namespace App\Requests\API;

use App\Exceptions\CoinPriceNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CoinGeckoAPI
{
    protected const BASE_URI = 'https://api.coingecko.com';

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * Get the price of a coin in a specific currency.
     *
     * @param string $from
     * @param string $to
     * @return float|null The coin price, or null if not found.
     * @throws CoinPriceNotFoundException|GuzzleException
     */
    public function getCoinPrice(string $from = 'bitcoin', string $to = 'uah'): ?float
    {
        $params = [
            'query' => [
                'ids' => $from,
                'vs_currencies' => $to,
            ],
        ];

        $apiUrl = "/api/v3/simple/price/";

        $response = $this->client->get($apiUrl, $params);
        $data = json_decode($response->getBody(), true);

        if (empty($price = $data[$from][$to])) {
            throw new CoinPriceNotFoundException("Coin price for {$from} in {$to} not found");
        }

        return $price;
    }
}
