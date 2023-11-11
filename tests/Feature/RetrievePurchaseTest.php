<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrievePurchaseTest extends TestCase
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
    function retrieve_purchase_details()
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
                    'quantity' => 20,
                ],
                [
                    'item_id' => 2,
                    'quantity' => 10
                ]
            ]
        ])->assertStatus(200);
        
        $purchase = Purchase::find(1);
        $response = $this->get('/api/purchases/' . $purchase->id);

        list($date, $_) = preg_split('/ /', $purchase->created_at);
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'purchases',
                    'purchase_id' => $purchase->id,
                    'attributes' => [
                        'status' => $purchase->status,
                        'purchase_day' => $date,
                        'customer' => [
                            'data' => [
                                'type' => 'customers',
                                'customer_id' => $customer->id,
                            ]
                        ],
                        'receipt' => [
                            'data' => [
                                [
                                    'data' => [
                                        'type'=> 'receipt',
                                        'attributes' => [
                                            'item_id' => 1,
                                            'item_name' => 'カット',
                                            'price' => 6000,
                                            'quantity' => 20,
                                        ]
                                    ],
                                ],
                                [
                                    'data' => [
                                        'type'=> 'receipt',
                                        'attributes' => [
                                            'item_id' => 2,
                                            'item_name' => 'カラー',
                                            'price' => 8000,
                                            'quantity' => 10,
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/purchases/' . $purchase->id)
                ]
            ]);
    }
}
