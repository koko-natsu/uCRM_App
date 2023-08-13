<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterCustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
    }


    /** @test */
    function a_user_can_register_a_customer()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::find(1));

        $response = $this->post('/api/customers', [
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

        $customer = Customer::find(1);

        $this->assertCount(1, Customer::all());
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'customers',
                            'customer_id' => $customer->id,
                            'attributes' => [
                                'name' => $customer->name,
                                'kana' => $customer->kana,
                                'tel' => $customer->tel,
                                'email' => $customer->email,
                                'postcode' => $customer->postcode,
                                'address' => $customer->address,
                                'birthday' => $customer->birthday,
                                'gender' => $customer->gender,
                                'memo' => $customer->memo,
                            ]
                        ],
                        'links' => [
                            'self' => url('/customers/' .$customer->id)
                        ]
                    ]
                ]
            ]);
    }
}
