<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Box;
class Item extends Model
{
    protected $fillable = ['name', 'category_id', 'price', 'quantity'];

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }
}
