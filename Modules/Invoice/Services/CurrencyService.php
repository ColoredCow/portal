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
            'base_uri' => 'http://apilayer.net/api',
            // 'base_uri' => 'https://api.apilayer.com/currency_data',
        ]);
    }

    public function getCurrentRatesInINR()
    {
        $seconds = 1 ;

        return Cache::remember('current_usd_rates', $seconds, function () {
            return $this->fetchExchangeRateInINR();
        });
    }

    private function fetchExchangeRateInINR()
    {
        if (! config('services.currencylayer.access_key')) {
            return round(config('services.currencylayer.default_rate'), 2);
        }

        $response = $this->client->get('live', [
            'query' => [
                'access_key' => config('services.currencylayer.access_key'),
                'currencies' => 'INR, EUR',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        dd($data);

        $usdinr = round($data['quotes']['USDINR'], 2);
        $usdeur = round($data['quotes']['USDEUR'], 2);

        return [
            'USD' => $usdinr,
            'EUR' => $usdeur,
        ];
    }
}
