<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use App\Http\Traits\Date;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RetrieveOrdersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            ItemSeeder::class,
        ]);
        Customer::factory()->create();
    }


    /** @test */
    function retrieve_orders()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        $customer = Customer::find(1);

        $this->post('/api/purchases', [
            'customer_id' => $customer->id,
            'status' => 1,
            'items' => [
                [
                    'item_id' => 1,
                    'quantity' => 1,
                ],
                [
                    'item_id' => 2,
                    'quantity' => 4,
                ],
            ]
        ]);

        $this->post('/api/purchases', [
            'customer_id' => $customer->id,
            'status' => 1,
            'items' => [
                [
                    'item_id' => 1,
                    'quantity' => 1,
                ],
                [
                    'item_id' => 2,
                    'quantity' => 4,
                ],
            ]
        ]);

        $total = (Item::find(1)->price * 1) + (Item::find(2)->price * 4);

        $purchase = Purchase::find(1);

        $date = Date::excerptDate($purchase->created_at);

        $response = $this->get('/purchases');

        $response->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->has('purchases', fn(Assert $page) => $page
                    ->has('data', 2, fn(Assert $page) => $page
                        ->has('data', fn(Assert $page) => $page
                            ->where('type', 'purchases')
                            ->where('purchase_id', $purchase->id)
                            ->has('attributes', fn(Assert $page) => $page
                                ->whereType('status', 'integer|1')
                                ->where('total', $total)
                                ->where('purchase_day', $date)
                                ->has('customer')
                                ->has('receipt')
                            )
                        )
                        ->has('links', fn(Assert $page) => $page
                            ->where('self', url('/purchases/1'))
                        )
                    )
                    ->has('links', fn(Assert $page) => $page
                        ->where('self', url('/purchases'))
                    )
                )
            );  
    }
}
