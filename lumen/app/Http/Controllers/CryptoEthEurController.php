<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

final class CryptoEthEurController extends BaseController
{
    public function __invoke(): Response
    {
        $response = \json_decode(
            (string) \file_get_contents('https://api2.binance.com/api/v3/ticker/24hr?symbol=ETHEUR'),
            true
        );

        if (empty($response)) {
            return \response(['error' => 'no response from the remote API'], 400);
        }

        return \response([
            'symbol'         => 'ETH/EUR',
            'price'          => $response['weightedAvgPrice'],
            'change_percent' => $response['priceChangePercent'],
            'volume'         => \number_format($response['quoteVolume']),
        ]);
    }
}
