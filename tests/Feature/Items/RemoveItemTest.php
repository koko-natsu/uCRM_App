<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
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
    }

    /** @test */
    function a_user_can_remove_item()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));

        Item::factory(5)->create();
        $this->assertCount(5, Item::all());

        $this->delete('/api/items/1')
            ->assertStatus(200);

        $this->assertCount(4, Item::all());
    }
}
