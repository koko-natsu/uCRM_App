<?php

namespace Tests\Feature\purchases;

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemPurchases;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
            ItemSeeder::class
        ]);
        Customer::factory(2)->create();
    }


    /** @test */
    function a_user_can_create_a_purchase()
    {
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

        $response = $this->post('/api/purchases', [
            'customer_id' => $customer->id,
            'status' => 1,
            'items' => [
                [
                    'item_id' => 1,
                    'quantity' => 1,
                ],
                [
                    'item_id' => 3,
                    'quantity' => 4,
                ],
            ]
        ]);

        $purchase = Purchase::find(1);

        $this->assertCount(2, Purchase::all());
        $this->assertCount(4, ItemPurchases::all());

        $total_1 = (Item::find(1)->price * 1) + (Item::find(2)->price * 4);
        $total_2 = (Item::find(1)->price * 1) + (Item::find(3)->price * 4);

        list($date, $_) = preg_split('/ /', $purchase->created_at);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'purchases',
                            'purchase_id' => 1,
                            'attributes'  => [
                                'status'  => 1,
                                'total'   => $total_1,
                                'purchase_day' => $date,
                                'customer' => [
                                    'data' => [
                                        'type' => 'customers',
                                        'customer_id' => $customer->id,
                                        'attributes' => []
                                    ],
                                    'links' => [
                                        'self' => url('/customers/' . $customer->id),
                                    ]
                                ],
                                'receipt' => [

                                ],
                            ]
                        ],
                        'links' => [
                            'self' => url('/purchases/' . $purchase->id)
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'purchases',
                            'purchase_id' => 2,
                            'attributes'  => [
                                'status'  => 1,
                                'total'   => $total_2,
                                'purchase_day' => $date,
                                'customer' => [
                                    'data' => [
                                        'type' => 'customers',
                                        'customer_id' => $customer->id,
                                        'attributes' => []
                                    ],
                                    'links' => [
                                        'self' => url('/customers/' . $customer->id),
                                    ]
                                ],
                            ]
                        ],
                        'links' => [
                            'self' => url('/purchases/2')
                        ]
                    ],
                ],
                'links' => [
                    'self' => url('/purchases'),
                ]
            ]);
    }
}
