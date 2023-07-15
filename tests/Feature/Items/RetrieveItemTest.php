<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RetrieveItemTest extends TestCase
{
    use RefreshDatabase;

    protected function  setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }

    /** @test */
    function a_user_can_retrieve_items()
    {
        $this->actingAs($user = User::find(1));

        Item::factory(5)->create();
        $this->assertCount(5, Item::all());
        
        $response = $this->get('/items');
        $item = Item::first();

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('items', fn(Assert $page) => $page
                    ->has('data', 5, fn(Assert $page) => $page
                        ->has('data', fn(Assert $page) => $page
                            ->where('type', 'items')
                            ->where('item_id', $item->id)
                            ->has('attributes', fn(Assert $page) => $page
                                ->where('name', $item->name)
                                ->where('memo', $item->memo)
                                ->where('price', $item->price)
                                ->whereType('is_selling', 'integer|1')
                            )
                        )
                        ->has('links', fn(Assert $page) => $page
                            ->where('self', url('/items/1'))
                        )
                    )
                    ->has('links', fn(Assert $page) => $page
                        ->where('self', url('/items'))
                    )
                )
            );
    }


    /** @test */
    function a_user_can_retrieve_a_item()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::find(1));

        $item = Item::factory()->create();

        $response = $this->get("/api/items/{$item->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'items',
                    'item_id' => $item->id,
                    'attributes' => [
                        'name' => $item->name,
                        'price' => $item->price,
                        'memo' => $item->memo,
                        'is_selling' => $item->is_selling,
                    ]
                ],
                'links' => [
                    'self' => url("/items/{$item->id}")
                ]
            ]);
    }
}
