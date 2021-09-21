<?php

namespace App\Services;

use App\Models\Cart;

class CartService
{
    public function createAddressFormat(array $user)
    {
        $notComplated = (
            !$user['address_one'] || 
            !$user['address_two'] || 
            !$user['provincy'] ||
            !$user['regency'] ||
            !$user['zip_code'] ||
            !$user['country'] ||
            !$user['phone_number']
        );

        return $notComplated ? '-' : $user['address_one'].' ( secondary address: '.$user['address_two'] .'), '.$user['regency'].', '.$user['provincy'].', '.$user['zip_code'].', '.$user['country'];
    }

    public function updateOrCreateCart(array $data)
    {
        if (self::getData($data['product_id']))
        {
            self::updateCart($data);
        }

        if (!self::getData($data['product_id']))
        {
            self::storeCart($data);
        }
    }

    private static function updateCart(array $data)
    {
        $cart = self::getData($data['product_id']);

        $cart->purchase_quantity = $cart->purchase_quantity + $data['purchase_quantity'];

        $cart->save();
    }

    private static function storeCart(array $data)
    {
        auth()->user()->carts()->create($data);
    }

    private static function getData(int $id)
    {
        return Cart::where('product_id', $id)->first();
    }

}
