<?php

namespace App;

use App\Book;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    const TABLE = 'categories';

    public function books()
    {
    	return $this->hasMany(Book::class);
    }
}
