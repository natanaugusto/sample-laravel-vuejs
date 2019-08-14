<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Tests\PassportActingAsTrait;

class ProductsTest extends TestCase
{
    use PassportActingAsTrait;

    public function testGetProducts()
    {
        $this->passportActingAs('admin');
        factory(Product::class, 30)->create();
        $products = Product::paginate((new Product())->getPerPage());
        $products->withPath(route('products.index'));
        $this->get('/api/products')
            ->assertStatus(200)
            ->assertJson($products->toArray());
            
        $this->get('/api/products?page=2')
            ->assertStatus(200);
        
        $this->passportActingAs();
        $this->get('/api/products')
            ->assertStatus(401);
    }

    public function testGetOneProduct()
    {
        $this->passportActingAs('admin');
        $product = factory(Product::class)->create();
        $this->get("/api/products/{$product->id}")
            ->assertStatus(200)
            ->assertJson($product->toArray());
        
        $this->passportActingAs();
        $this->get("/api/products/{$product->id}")
            ->assertStatus(401);
    }

    public function testPostProduct()
    {
        $this->passportActingAs('admin');
        $product = factory(Product::class)->make()->toArray();
        $this->post('/api/products', $product)
            ->assertStatus(201)
            ->assertJson($product);
        
        $this->post('/api/products', $product)
            ->assertStatus(422);
        
        $this->passportActingAs();
        $this->post('/api/products', $product)
            ->assertStatus(401);
    }

    public function testPutProduct()
    {
        $this->passportActingAs('admin');
        $product = factory(Product::class)->create()->toArray();
        $this->put("/api/products/{$product['id']}", $product)
            ->assertStatus(201)
            ->assertJson($product);
        
        $product['price'] = 'error';
        $this->put("/api/products/{$product['id']}", $product)
            ->assertStatus(422);
        
        $this->passportActingAs();
        $this->put("/api/products/{$product['id']}", $product)
            ->assertStatus(401);
    }

    public function testDeleteProduct()
    {
        $this->passportActingAs('admin');
        $product = factory(Product::class)->create();
        $this->delete("/api/products/{$product->id}")
            ->assertStatus(204);
        
        $this->passportActingAs();
        $this->delete("/api/products/{$product->id}")
            ->assertStatus(401);
    }
}