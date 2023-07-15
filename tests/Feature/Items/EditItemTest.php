<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EditItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();

        Item::create([
            'name' => 'New Item',
            'price' => 2000,
            'memo' => 'New Item Memo',
            'is_selling' => 1,
        ]);
    }

    /** @test */
    function a_user_can_change_item_info()
    {
        $this->actingAs(User::find(1));
        $item = Item::find(1);
        $this->assertEquals('New Item', $item->name);

        $this->patch('/api/items/1', [
            'name' => 'Update Item'
        ])->assertStatus(200);

        $item = Item::find(1);
        $this->assertEquals('Update Item', $item->name);
    }

}
