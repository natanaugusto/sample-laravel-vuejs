<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static $rules = [
        'name' => 'required|max:50|unique:categories',
        'slug' => 'required|max:50|unique:categories',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
