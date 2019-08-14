<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Tests\PassportActingAsTrait;

class CategoriesTest extends TestCase
{
    use PassportActingAsTrait;

    public function testGetCategories()
    {
        $this->passportActingAs('admin');
        factory(Category::class, 5)->create();
        $categories = Category::all();
        $this->get('/api/categories')
            ->assertStatus(200)
            ->assertJson($categories->toArray());
        
        $this->passportActingAs();
        $this->get('/api/categories')
            ->assertStatus(401);
    }

    public function testGetOneCategory()
    {
        $this->passportActingAs('admin');
        $category = factory(Category::class)->create();
        $this->get("/api/categories/{$category->id}")
            ->assertStatus(200)
            ->assertJson($category->toArray());
        
        $this->passportActingAs();
        $this->get("/api/categories/{$category->id}")
            ->assertStatus(401);
    }

    public function testPostCategory()
    {
        $this->passportActingAs('admin');
        $category = factory(Category::class)->make()->toArray();
        $this->post('/api/categories', $category)
            ->assertStatus(201)
            ->assertJson($category);
        
        $this->post('/api/categories', $category)
            ->assertStatus(422);
        
        $this->passportActingAs();
        $this->post('/api/categories', $category)
            ->assertStatus(401);
    }

    public function testPutCategory()
    {
        $this->passportActingAs('admin');
        $category = factory(Category::class)->create()->toArray();
        $this->put("/api/categories/{$category['id']}", $category)
            ->assertStatus(201)
            ->assertJson($category);
        
        $category['slug'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->put("/api/categories/{$category['id']}", $category)
            ->assertStatus(422);
        
        $this->passportActingAs();
        $this->put("/api/categories/{$category['id']}", $category)
            ->assertStatus(401);
    }

    public function testDeleteCategory()
    {
        $this->passportActingAs('admin');
        $category = factory(Category::class)->create();
        $this->delete("/api/categories/{$category->id}")
            ->assertStatus(204);
        
        $this->passportActingAs();
        $this->delete("/api/categories/{$category->id}")
            ->assertStatus(401);
    }
}