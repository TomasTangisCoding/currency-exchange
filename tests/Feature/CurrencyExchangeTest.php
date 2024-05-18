<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    public function test_currency_exchange_returns_a_successful_response(): void
    {
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '100',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);
    }

    public function test_currency_exchange_amount_is_not_number()
    {
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => 'abc',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(400);

        $response->assertJson([
            'success' => false,
            'message' => 'The amount field format is invalid.',
        ]);
    }

    public function test_currency_exchange_currency_is_not_supported()
    {
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'RMB',
            'amount' => '100',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(400);

        $response->assertJson([
            'success' => false,
            'message' => 'The target currency is not supported.',
        ]);

        $query = http_build_query([
            'source' => 'RMB',
            'target' => 'JPY',
            'amount' => '100',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(400);

        $response->assertJson([
            'success' => false,
            'message' => 'The source currency is not supported.',
        ]);
    }

    public function test_currency_exchange_amount_cover_by_several_number()
    {
        // Case with no decimal place
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1234',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with one decimal place
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1234.5',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with two decimal places
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1234.56',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with three decimal places
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1234.567',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with comma-separated thousand
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1,234',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with comma-separated thousand and three decimal places
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1,234.567',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with two comma-separated and three decimal places
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1,234,567.567',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);

        // Case with three comma-separated and more than three decimal places
        $query = http_build_query([
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => '1,234,567,890.1234',
        ]);

        $response = $this->get('/currencyExchange?' . $query);

        $response->assertStatus(200);
    }
}
