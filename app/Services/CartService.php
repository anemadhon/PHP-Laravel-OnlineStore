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

        return $notComplated ? '-' : $user['address_one'].' ( secondary address: '.$user['address_two'] .' ), '.$user['regency'].', '.$user['provincy'].', '.$user['zip_code'].', '.$user['country'];
    }

    public function updateOrCreateCart(array $data)
    {
        if (self::getProduct($data['product_id']))
        {
            self::updateCart($data);
        }

        if (!self::getProduct($data['product_id']))
        {
            self::storeCart($data);
        }
    }

    private static function updateCart(array $data)
    {
        $cart = self::getProduct($data['product_id']);

        $cart->purchase_quantity = $cart->purchase_quantity + $data['purchase_quantity'];

        $cart->save();

        return;
    }

    private static function storeCart(array $data)
    {
        Cart::create($data);

        return;
    }

    private static function getProduct(int $id)
    {
        return Cart::where('product_id', $id)->first();
    }

}
