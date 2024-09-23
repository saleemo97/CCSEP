<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb'; // MongoDB connection
    protected $collection = 'posts'; // MongoDB collection name
    protected $fillable = ['title', 'content']; // Fillable fields
}
