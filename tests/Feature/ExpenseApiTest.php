<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_expense_store(): void
    {
        $response = $this->post('/expense-store');

        $response->assertStatus(404);
        $response->assertJsonStructure([
            '*' => ['description', 'amount', 'date', 'category'],
        ]);
    }
}
