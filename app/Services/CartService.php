<?php

namespace App\Services;

use App\Models\Cart;

class CartService
{
    public function createAddressFormat(object $userLogin)
    {
        $notComplated = (
            !$userLogin->address_one || 
            !$userLogin->address_two || 
            !$userLogin->provincy ||
            !$userLogin->regency ||
            !$userLogin->zip_code ||
            !$userLogin->country ||
            !$userLogin->phone_number
        );

        return $notComplated ? '-' : $userLogin->address_one.' ( secondary address: '.$userLogin->address_two .'), '.$userLogin->regency.', '.$userLogin->provincy.', '.$userLogin->zip_code.', '.$userLogin->country;
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
