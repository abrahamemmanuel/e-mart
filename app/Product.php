<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // public function path()
    // {
    //   return '/products/' . $this->id . '-' . Str::slug($this->name);
    // }

    public function totalPrice()
    {
        return $this->discount !== null ? round((1 - ($this->discount / 100)) * $this->price, 2) : $this->price;
    }

}
