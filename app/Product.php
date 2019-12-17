<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];


    public function totalPrice()
    {
        return  $this->discount !== null ? round((1 - ($this->discount / 100)) * $this->price, 2) : $this->price;
    }

    // public function setPriceAttribute($price)
    // {
    //     // $this->attributes['price'] = (int)$price;
    // }

    // public function setStockAttribute($stock)
    // {
    //     $this->attributes['stock'] = (int) $stock;
    // }
}
