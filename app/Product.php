<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $perPage = 10;
  protected $appends = ['category_name'];
  protected $hidden = ['category'];
  public static $rules = [
    'name' => 'required|max:64|unique:products',
    'description' => 'max:254',
    'category_id' => 'required|exists:categories,id',
    'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
  ];


  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function getCategoryNameAttribute()
  {
    return $this->category->name;
  }
}
