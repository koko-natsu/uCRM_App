<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;

class RetrieveCustomersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
        ]);
        Customer::factory(5)->create();
    }

    /** @test */
    function a_user_can_retrieve_customers_info()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        $customers = Customer::all();

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


    /** @test */
    function can_retrieve_a_customer_info()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        $customer = Customer::factory()->create();

        $response = $this->get("/api/customers/{$customer->id}");

        list($last_name, $fist_name) = preg_split("/\s/", $customer->name);
        list($last_kana, $fist_kana) = preg_split("/\s/", $customer->kana);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'customers',
                    'customer_id' => $customer->id,
                    'attributes' => [
                        'name' =>[
                            'first_name' => $fist_name,
                            'last_name'  => $last_name,
                        ],
                        'kana' =>[
                            'first_name' => $fist_kana,
                            'last_name'  => $last_kana,
                        ],
                        'tel' => $customer->tel,
                        'email' => $customer->email,
                        'postcode' => $customer->postcode,
                        'address' => $customer->address,
                        'birthday' => $customer->birthday,
                        'gender' => $customer->gender,
                        'memo' => $customer->memo,
                    ]
                ],
                'links' => [
                    'self' => url("/customers/{$customer->id}")
                ]
            ]);
    }
}
