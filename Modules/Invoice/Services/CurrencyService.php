<?php

namespace Modules\Invoice\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
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

    protected function setClient(): void
    {
        $headers = [
            'apikey' => config('services.currencylayer.access_key'),
        ];

        $this->client = new Client([
            'base_uri' => 'https://api.apilayer.com',
            'headers'  => $headers,
            'timeout'  => 10,
            'connect_timeout' => 5,
        ]);
    }

    public function getCurrentRatesInINR()
    {
        $seconds = 1 * 60 * 60 * 4;

        return Cache::remember('current_usd_rates', $seconds, function () {
            return $this->fetchExchangeRateInINR();
        });
    }

    public function getAllCurrentRatesInINR()
    {
        $seconds =  1 * 60 * 60 * 4;

        return Cache::remember('all_current_usd_rates', $seconds, function () {
            return $this->fetchAllExchangeRateInINR();
        });
    }

    private function fetchExchangeRateInINR()
    {
        if (!config('services.currencylayer.access_key')) {
            Log::warning('CurrencyLayer API key missing. Using default rate.');
            return round(config('services.currencylayer.default_rate', 83.00), 2);
        }

        try {
            $response = $this->client->get('currency_data/live', [
                'query' => [
                    'currencies' => 'INR',
                    'source'     => 'USD',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data) || empty($data['quotes']['USDINR'])) {
                throw new \Exception('Invalid API response structure.');
            }

            return round($data['quotes']['USDINR'], 2);
        } catch (ConnectException $e) {
            Log::error('Currency API connection failed: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('Currency API request error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Unexpected error fetching exchange rate: ' . $e->getMessage());
        }

        // fallback to default value if everything fails
        return round(config('services.currencylayer.default_rate', 83.00), 2);
    }

    private function fetchAllExchangeRateInINR()
    {
        if (!config('services.currencylayer.access_key')) {
            Log::warning('CurrencyLayer API key missing. Using default rate.');
            return [
                'USDINR' => round(config('services.currencylayer.default_rate', 83.00), 2)
            ];
        }

        try {
            $response = $this->client->get('currency_data/live', [
                'query' => [
                    'source' => 'USD',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data) || empty($data['quotes'])) {
                throw new \Exception('Invalid API response structure.');
            }

            return $data['quotes'];
        } catch (ConnectException $e) {
            Log::error('Currency API connection failed: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('Currency API request error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Unexpected error fetching all exchange rates: ' . $e->getMessage());
        }

        // fallback if API fails
        return [
            'USDINR' => round(config('services.currencylayer.default_rate', 83.00), 2)
        ];
    }
}
