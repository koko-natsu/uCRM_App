<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RetrieveCustomersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }

    /** @test */
    function a_user_can_retrieve_customers_info()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        $customers = Customer::factory(5)->create();

        $this->assertCount(5, $customers);

        $response = $this->get('/customers');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('customers', fn(Assert $page) => $page
                    ->has('data', 5)
                    ->etc()
                    )
            );
    }
}
