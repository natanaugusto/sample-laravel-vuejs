<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
  protected $categories = [
    [
      'id' => 1,
      'name' => 'Armor',
      'slug' => 'armor',
    ],
    [
      'id' => 2,
      'name' => 'Sword',
      'slug' => 'sword',
    ],
    [
      'id' => 3,
      'name' => 'Helmet',
      'slug' => 'helmet',
    ],
    [
      'id' => 4,
      'name' => 'Shield',
      'slug' => 'shield',
      ]
    ];
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
      foreach($this->categories as $fields) {
        $category = new Category();
        $category->id = $fields['id'];
        $category->name = $fields['name'];
        $category->slug = $fields['slug'];
        $category->save();
      }
    }
  }
