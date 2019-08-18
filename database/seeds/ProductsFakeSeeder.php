<?php

use App\Product;
use App\Category;
use Illuminate\Database\Seeder;

class ProductsFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::select('id')->get();
        foreach($categories as $category) {
            factory(Product::class, 10)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
