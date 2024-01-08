<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\User;
use App\Http\Traits\Date;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RetrieveCustomersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
            ItemSeeder::class,
        ]);
        Customer::factory(5)->create();
    }

    /** @test */
    function a_user_can_retrieve_customers_info_with_purchases_history()
    {
        $this->actingAs(User::find(1));
        $customers = Customer::all();
        $customer = Customer::find(1);
        
        $this->assertCount(5, $customers);

        $this->post('/api/purchases', [
            'customer_id' => $customer->id,
            'status' => 1,
            'items' => [
                [
                    'item_id' => 1,
                    'quantity' => 20,
                ]
            ]
        ])->assertStatus(200);


        $response = $this->get('/customers');

        $date = Date::excerptDate($customer->purchases->last()->created_at);

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('customers', fn(Assert $page) => $page
                    ->has('data', 5, fn(Assert $page) => $page
                         ->has('data', fn(Assert $page) => $page
                            ->where('type', 'customers')
                            ->where('customer_id', $customer->id)
                            ->has('attributes', fn(Assert $page) => $page
                                ->where('name', $customer->name)
                                ->where('kana', $customer->kana)
                                ->where('tel', $customer->tel)
                                ->where('email', $customer->email)
                                ->where('postcode', $customer->postcode)
                                ->where('address', $customer->address)
                                ->where('birthday', $customer->birthday)
                                ->where('gender', $customer->gender)
                                ->where('memo', $customer->memo)
                                ->where('num_of_purchases', $customer->purchases->count())
                                ->where('most_recent', $date)
                            )
                         )
                         ->has('links')
                    )
                    ->etc()
                    )
            );
    }

    /** @test */
    function a_user_can_retrieve_customers_info_without_purchases_history()
    {
        $this->actingAs(User::find(1));
        $customer = Customer::find(1);

        $response = $this->get('/customers');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('customers', fn(Assert $page) => $page
                    ->has('data', 5, fn(Assert $page) => $page
                         ->has('data', fn(Assert $page) => $page
                            ->where('type', 'customers')
                            ->where('customer_id', $customer->id)
                            ->has('attributes', fn(Assert $page) => $page
                                ->where('num_of_purchases', 0)
                                ->where('most_recent', '--/--/--')
                                ->etc()
                            )
                         )
                         ->has('links')
                    )
                    ->etc()
                    )
            );
    }


    /** @test */
    function can_retrieve_a_customer_info()
    {
        $this->actingAs(User::find(1));
        $customer = Customer::find(1);

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
                    ],
                ],
                'links' => [
                    'self' => url("/customers/{$customer->id}")
                ]
            ]);
    }

}
