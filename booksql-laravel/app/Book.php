<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    const TABLE = 'books';

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}
