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
        $headers = $headers = [
            'apikey' => config('services.currencylayer.access_key')
        ];
        $this->client = new Client([
            // 'base_uri' => 'http://apilayer.net/api',    //This is old API URL 
            'base_uri' => 'https://api.apilayer.com',  // This is new API created from https://apilayer.com/marketplace/currency_data-api
            'headers' => $headers
        ]);
    }

    public function getCurrentRatesInINR()
    {
        $seconds = 1;

        return Cache::remember('current_usd_rates', $seconds, function () {
            return $this->fetchExchangeRateInINR();
        });
    }

    private function fetchExchangeRateInINR()
    {
        if (! config('services.currencylayer.access_key')) {
            return round(config('services.currencylayer.default_rate'), 2);
        }

        $response = $this->client->get('currency_data/live', [
            'query' => [
                'access_key' => config('services.currencylayer.access_key'),
                'currencies' => 'INR',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return round($data['quotes']['USDINR'], 2);
    }
}
