<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    protected $categories = [
        [
            'id' => 1,
            'name' => 'Armadura',
            'slug' => 'armadura',
        ],
        [
            'id' => 2,
            'name' => 'Espada',
            'slug' => 'espada',
        ],
        [
            'id' => 3,
            'name' => 'Elmo',
            'slug' => 'elmo',
        ],
        [
            'id' => 4,
            'name' => 'Poção Mágica',
            'slug' => 'pocao_magica',
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
