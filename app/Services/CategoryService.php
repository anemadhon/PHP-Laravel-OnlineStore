<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function uploadIcons(array $data)
    {
        return $data['icon']->storePubliclyAs('assets/categories', self::createFileName($data), 'public');
    }

    private static function createFileName(array $data)
    {
        if ($data['slug'])
        {
            return $data['slug'].'-icons.'.$data['icon']->extension();
        }

        return self::checkSlug($data['category_name']).'-icons.'.$data['icon']->extension();
    }

    private static function checkSlug(string $name)
    {
        $totalAvailableName = Category::where('name', $name)->count();
        
        if ($totalAvailableName > 0)
        {
            return Str::slug($name).'-'.($totalAvailableName + 1);
        }

        return Str::slug($name);
    }
}
