<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrieveAddressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }


    /** @test */
    function a_user_can_retrieve_address_using_postcode()
    {
        $this->actingAs(User::find(1));

        $response = $this->get('/api/retrieve-address/3700321');

        $response->assertStatus(200)
            ->assertJson([
                'address' => '群馬県太田市新田木崎町'
            ]);
    }


    /** @test */
    function a_user_cannot_retrieve_address()
    {
        $this->actingAs(User::find(1));

        $response = $this->get('/api/retrieve-address/000000');

        $response->assertStatus(400)
            ->assertJson([
                'message' => '入力された郵便番号が、間違っています。',
            ]);
    }
}
