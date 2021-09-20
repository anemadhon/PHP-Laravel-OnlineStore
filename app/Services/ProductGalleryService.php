<?php 

namespace App\Services;

use App\Models\Product;

class ProductGalleryService
{
    public function uploadImages(array $data)
    {
        $product = self::getProduct($data['product_id']);

        $path = 'assets/'.$product->store->name.'/'.$product->name;

        return $data['image']->storePubliclyAs($path, self::createFileName($data), 'public');
    }

    private static function createFileName(array $data)
    {
        $product = self::getProduct($data['product_id']);

        return $product->slug.'-gallery.'.$data['image']->extension();
    }

    private static function getProduct($id)
    {
        return Product::with('store')->where('id', $id)->first();
    }
}
