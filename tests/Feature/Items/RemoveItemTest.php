<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        $this->seed(ItemSeeder::class);
    }

    /** @test */
    function a_user_can_remove_item()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));

        $this->assertCount(3, Item::all());

        $this->delete('/api/items/1')
            ->assertStatus(200);

        $this->assertCount(2, Item::all());
    }
}
