<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveCustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }

    /** @test */
    function can_remove_a_customer()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        Customer::factory(5)->create();

        $this->assertCount(5, Customer::all());

        $this->delete('/api/customers/1')
            ->assertStatus(200);

        $this->assertCount(4, Customer::all());
    }
}
