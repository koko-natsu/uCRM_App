<?php

namespace Tests\Feature\Purchases;

use App\Models\Customer;
use App\Models\ItemPurchases;
use App\Models\User;
use App\Models\Purchase;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemovePurchaseTest extends TestCase
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
    function can_remove_a_purchase()
    {
        $this->actingAs(User::find(1));
        $customer = Customer::find(1);

        $this->post('/api/purchases', [
            'customer_id' => $customer->id,
            'status'      => 1,
            'items'       => [
                [
                    'item_id'  => 1,
                    'quantity' => 10
                ],
                [
                    'item_id'  => 2,
                    'quantity' => 20
                ],
            ]
        ])->assertStatus(200);

        $this->assertCount(1, Purchase::all());
        $purchase = Purchase::find(1);
        $this->assertCount(2, ItemPurchases::all());
        $this->delete("/api/purchases/{$purchase->id}")
                ->assertStatus(200);


        $this->assertCount(0, Purchase::all());
        $this->assertCount(0, ItemPurchases::all());
    }
}
