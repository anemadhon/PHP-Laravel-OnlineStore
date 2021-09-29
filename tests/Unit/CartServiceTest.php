<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\CartService;

class CartServiceTest extends TestCase
{
    public function test_user_details_data_for_address_is_not_completed()
    {
        $address = (new CartService())->createAddressFormat([
            'address_one' => '',
            'address_two' => '',
            'provincy' => '',
            'regency' => '',
            'zip_code' => '',
            'country' => '',
            'phone_number' => ''
        ]);

        $this->assertEquals('-', $address);
    }
    
    public function test_user_details_data_for_address_is_completed()
    {
        $address = (new CartService())->createAddressFormat([
            'address_one' => 'Bermis',
            'address_two' => 'Bumi Indah',
            'provincy' => 'Banten',
            'regency' => 'Kab. Tangerang',
            'zip_code' => '15560',
            'country' => 'Indonesia',
            'phone_number' => '0812'
        ]);

        $expected = 'Bermis ( secondary address: Bumi Indah ), Kab. Tangerang, Banten, 15560, Indonesia';

        $this->assertEquals($expected, $address);
    }

    public function test_user_add_new_product_into_the_cart()
    {
        $user = User::factory()->create();

        $newCart = (new CartService())->updateOrCreateCart([
            'user_id' => $user->id,
            'product_id' => 1,
            'purchase_quantity' => 2
        ]);

        $this->assertEquals(null, $newCart);
    }
    
    public function test_user_add_same_product_into_the_cart_twice()
    {
        $user = User::factory()->create();

        $newCart = (new CartService())->updateOrCreateCart([
            'user_id' => $user->id,
            'product_id' => 1,
            'purchase_quantity' => 2
        ]);

        $this->assertEquals(null, $newCart);
    }
}
