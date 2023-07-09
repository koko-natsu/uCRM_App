<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CreateItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }

    /** @test */
    function a_user_can_create_a_item()
    {
        $this->actingAs($user = User::find(1));

        $response = $this->post('/api/items', [
            'name' => 'TestItem',
            'memo' => 'TestItemMemo',
            'price' => 1000,
            'is_selling' => true,
        ]);

        $item = Item::first();

        $this->assertCount(1, Item::all());
        $this->assertEquals('TestItem', $item->name);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'items',
                    'item_id' => $item->id,
                    'attributes' => [
                        'name' => $item->name,
                        'memo' => $item->memo,
                        'price' => $item->price,
                        'is_selling' => $item->is_selling,
                    ]
                ],
                'links' => [
                    'self' => url('/items/' .$item->id),
                ]
            ]);
    }
}
