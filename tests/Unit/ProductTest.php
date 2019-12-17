<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function product_total_price_when_discount_is_given()
    {
        $product = Product::create($this->data());
        $totalPrice = round((1 - ($product->discount / 100)) * $product->price, 2);

        $this->assertCount(1, Product::all());
        $this->assertEquals(95.0, $totalPrice);
        $this->assertEquals($totalPrice, $product->totalPrice());
    }

    /** @test */
    public function product_total_price_when_discount_is_not_given()
    {
        $product = Product::create(array_merge($this->data(), ['discount' => null]));
        $totalPrice = $product->price;

        $this->assertCount(1, Product::all());
        $this->assertEquals(100, $totalPrice);
        $this->assertEquals($totalPrice, $product->totalPrice());
    }

    public function data()
    {
        return [
            'name' => 'Iphone X',
            'description' => 'Latest Iphone in town',
            'price' => 100,
            'stock' => 2,
            'discount' => 5,
        ];
    }

}
