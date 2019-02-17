<?php

namespace App;
use App\Item;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['name'];

    public function Item ()
    {
        return $this->hasMany('App\Item');
    }
}
