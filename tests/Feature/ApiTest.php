<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    private static function getToken()
    {
        return ['Authorization' => 'Bearer ' . config('services.api.token')];
    }

    public function testAuthentification(): void
    {
        $response = $this->get('/api/v1');

        $response->assertStatus(401);
    }

    public function testGetRates(): void
    {
        $response = $this->get('/api/v1?method=rates', self::getToken());

        $response->assertStatus(200);
    }

    public function testGetRatesCurrency(): void
    {
        $response = $this->get('/api/v1?method=rates&currency=USD,AUD,RUB', self::getToken());

        $response->assertStatus(200);
    }

    public function testGetRatesCurrencyFail(): void
    {
        $response = $this->get('/api/v1?method=rates?currency=USD,SFW,RUB', self::getToken());

        $response->assertStatus(403);
    }

    public function testConvertFromUSDToBTC(): void
    {
        $response = $this->post('/api/v1', [
            'method' => 'convert',
            'currency_from' => 'USD',
            'currency_to' => 'BTC',
            'value' => 1.0,
        ], self::getToken());

        $response->assertStatus(200);
    }

    public function testConvertFromBTCToUSD(): void
    {
        $response = $this->post('/api/v1', [
            'method' => 'convert',
            'currency_from' => 'BTC',
            'currency_to' => 'USD',
            'value' => 1.0,
        ], self::getToken());

        $response->assertStatus(200);
    }

    public function testConvertFail(): void
    {
        $response = $this->post('/api/v1', [
            'method' => 'convert',
            'currency_from' => 'USD',
            'currency_to' => 'USD',
            'value' => 1.0,
        ], self::getToken());

        $response->assertStatus(403);
    }
}
