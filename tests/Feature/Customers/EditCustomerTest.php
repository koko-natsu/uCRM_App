<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditCustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }


    /** @test */
    function a_user_can_edit_customer_information()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));
        $this->post('/api/customers', [
            'name' => 'テスト太郎',
            'kana' => 'テストタロウ',
            'tel' => '09012345678',
            'email' => 'test@test.com',
            'postcode' => '1234567',
            'address' => 'テスト県テスト市',
            'birthday' => '1900-01-01',
            'gender' => 1,
            'memo' => 'memo',
        ]);

        $this->assertCount(1, Customer::all());
        $edited_customer = Customer::find(1);

        $response = $this->patch('/api/customers/1', [
            'name' => 'テスト次郎',
        ]);

        $response->assertStatus(200)
            ->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'customers',
                        'customer_id' => $edited_customer->id,
                        'attributes' => [
                            'name' => 'テスト次郎',
                            'kana' => 'テストタロウ',
                            'tel' => '09012345678',
                            'email' => 'test@test.com',
                            'postcode' => '1234567',
                            'address' => 'テスト県テスト市',
                            'birthday' => '1900-01-01',
                            'gender' => 1,
                            'memo' => 'memo',
                        ]
                    ]
                ]
            ]
        ]);
    }
}
