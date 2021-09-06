<?php

namespace Modules\Invoice\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Modules\Invoice\Contracts\CurrencyServiceContract;

class CurrencyService implements CurrencyServiceContract
{
    protected $client;

    public function __construct()
    {
        $this->setClient();
    }

    public function setClient()
    {
        $this->client = new Client([
            'base_uri' => 'http://apilayer.net/api'
        ]);
    }

    public function getCurrentRatesInINR()
    {
        $seconds = 1 * 60 * 60 * 4;

        return Cache::remember('current_usd_rates', $seconds, function () {
            return $this->fetchExchangeRateInINR();
        });
    }

    private function fetchExchangeRateInINR()
    {
        $response = $this->client->get('live', [
            'query' => [
                'access_key' => config('services.currencylayer.access_key'),
                'currencies' => 'INR'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return round($data['quotes']['USDINR'], 2);
    }
}
