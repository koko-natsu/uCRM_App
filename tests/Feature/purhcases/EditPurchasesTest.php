<?php

namespace Tests\Feature\purhcases;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditPurchasesTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
            ItemSeeder::class,
        ]);
        Customer::factory(1)->create();
    }

    /** @test */
    function a_user_can_edit_a_purchase_with_valid_data()
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
                    'quantity' => 3,
                ],
            ]
        ]);

        $this->assertCount(1, Purchase::all());

        $changed_date = date('Y/m/d H:i:s');
        $response = $this->patch('/api/purchases/1', [
            'status' => 1,
            'updated_date' => $changed_date,
            'customer_id' => $customer->id,
            'items' => [
                [
                    'item_id' => 1,
                    'quantity' => 50,
                ],
                [
                    'item_id' => 2,
                    'quantity' => 40,
                ],
            ],
        ]);

        $total = (Item::find(id: 1)->price * 50) + (Item::find(id: 2)->price * 40);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'purchases',
                            'purchase_id' => 1,
                            'attributes' => [
                                'status' => Purchase::find(1)->status,
                                'total' => $total,
                                'purchase_day' => date('Y-m-d'),
                                'customer' => [
                                    'data' => [
                                        'type' => 'customers',
                                        'customer_id' => 1,
                                    ]
                                ]
                            ]
                        ],
                        'links' => [
                            'self' => url('/purchases/1')
                        ]
                    ]
                ]
            ]);
    }
}
