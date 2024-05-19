<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Requests\API\CoinGeckoAPI;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class RateController extends Controller
{
    /**
     * Get exchange rate
     *
     * @param CoinGeckoAPI $coinGeckoAPI
     * @return JsonResponse
     */
    public function getExchangeRate(CoinGeckoAPI $coinGeckoAPI): JsonResponse
    {
        try {
            return response()->json(['rate' => $coinGeckoAPI->getCoinPrice()]);
        } catch (\Exception|GuzzleException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
