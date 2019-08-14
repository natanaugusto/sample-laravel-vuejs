<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->firstName(),
        'slug' => $faker->unique()->slug(1),
    ];
});
