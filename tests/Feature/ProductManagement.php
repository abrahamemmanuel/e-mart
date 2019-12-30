<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_product_can_be_added_to_the_store()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/products', $this->data());

        $this->assertCount(1, Product::all());
        $response->assertStatus(201);
    }

    /** @test */
    public function a_product_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/products', $this->data());

        $product = Product::first();

        $response = $this->patch('/products/' . $product->id, [
            'name' => 'Samsung Galaxy',
            'description' => 'New phone',
            'price' => 100,
            'stock' => 5,
            'discount' => 5,
        ]);

        $this->assertEquals('Samsung Galaxy', Product::first()->name);
        $this->assertEquals('New phone', Product::first()->description);
        $response->assertStatus(200);
    }

    /** @test */
    public function a_product_can_be_deleted()
    {
        $this->post('/products', $this->data());

        $product = Product::first();

        $response = $this->delete('/products/' . $product->id);

        $this->assertCount(0, Product::all());
        $response->assertStatus(200);
    }

    /** @test */
    public function view_all_products()
    {
       $products = factory(Product::class, 10)->create();

       $response = $this->get('/products');

       $this->assertCount(10, Product::all());
       $response->assertStatus(200);
    }

        /** @test */
    public function view_a_single_product()
    {
       factory(Product::class, 10)->create();

       $response = $this->get('/products/' . Product::first()->id);

       $response->assertStatus(200);
    }

    /** @test */
    public function a_product_name_is_required()
    {
        $response = $this->post('/products', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');

    }

    /** @test */
    public function product_description_is_required()
    {
        $response = $this->post('/products', array_merge($this->data(), ['description' => '']));

        $response->assertSessionHasErrors('description');

    }

    /** @test */
    public function product_price_is_required()
    {
        $response = $this->post('/products', array_merge($this->data(), ['price' => '']));

        $response->assertSessionHasErrors('price');

    }

    /** @test */
    public function product_discount_is__not_required()
    {
        $response = $this->post('/products', array_merge($this->data(), ['discount' => '']));

        $response->assertSessionHasNoErrors('discount');
        $this->assertEmpty(Product::first()->discount);
    }

    /** @test */
    public function product_stock_is_required()
    {
        $response = $this->post('/products', array_merge($this->data(), ['stock' => '']));

        $response->assertSessionHasErrors('stock');
    }

    private function data()
    {
        return [
            'name' => 'Iphone X',
            'description' => 'Latest Iphone in town',
            'price' => 100,
            'stock' => 5,
            'discount' => 5,
        ];
    }
}
