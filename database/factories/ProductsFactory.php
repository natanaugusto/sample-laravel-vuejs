<?php

use App\Product;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $category = factory(Category::class)->create();
    return [
        'name' => $faker->unique()->name(),
        'description' => $faker->text(200),
        'category_id' => $category->id,
        'price' => $faker->randomFloat(2, 200, 10000),
    ];
});
