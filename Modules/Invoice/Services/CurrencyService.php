<?php

namespace Modules\Invoice\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
            'apikey' => config('services.currencylayer.access_key'),
        ];
        $this->client = new Client([
            // 'base_uri' => 'http://apilayer.net/api',    //This is old API URL
            'base_uri' => 'https://api.apilayer.com',  // This is new API created from https://apilayer.com/marketplace/currency_data-api
            'headers' => $headers,
        ]);
    }

    public function getCurrentRatesInINR()
    {
        $seconds = 1 * 60 * 60 * 4;
        $rate = Cache::get('current_usd_rates');

        if ($rate !== null) {
            return $rate;
        }

        $rate = $this->fetchExchangeRateInINR();

        if ($rate !== null) {
            Cache::put('current_usd_rates', $rate, $seconds);
        }

        return $rate;
    }

    public function getAllCurrentRatesInINR()
    {
        $seconds = 1 * 60 * 60 * 4;
        $rates = Cache::get('all_current_usd_rates');

        if ($rates !== null) {
            return $rates;
        }

        $rates = $this->fetchAllExchangeRateInINR();

        if ($rates !== null) {
            Cache::put('all_current_usd_rates', $rates, $seconds);
        }

        return $rates;
    }

    private function fetchExchangeRateInINR()
    {
        if (! config('services.currencylayer.access_key')) {
            return round(config('services.currencylayer.default_rate'), 2);
        }

        try {
            $response = $this->client->get('currency_data/live', [
                'query' => [
                    'access_key' => config('services.currencylayer.access_key'),
                    'currencies' => 'INR',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return round($data['quotes']['USDINR'], 2);
        } catch (RequestException $e) {
            Log::warning('Currency API request failed in fetchExchangeRateInINR: ' . $e->getMessage());

            return;
        }
    }

    private function fetchAllExchangeRateInINR()
    {
        if (! config('services.currencylayer.access_key')) {
            return round(config('services.currencylayer.default_rate'), 2);
        }

        try {
            $response = $this->client->get('currency_data/live', [
                'query' => [
                    'access_key' => config('services.currencylayer.access_key'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['quotes'];
        } catch (RequestException $e) {
            Log::warning('Currency API request failed in fetchAllExchangeRateInINR: ' . $e->getMessage());

            return;
        }
    }
}
