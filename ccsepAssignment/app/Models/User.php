<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent; // Using MongoDB Eloquent model
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable; // Trait to handle auth

class User extends Eloquent implements AuthenticatableContract
{
    use Authenticatable; // This trait implements the methods required by the Authenticatable contract

    protected $connection = 'mongodb'; // MongoDB connection
    protected $collection = 'users'; // MongoDB collection name

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
