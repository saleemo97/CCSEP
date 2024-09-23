<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePostsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // MongoDB doesn't use the traditional schema-based structure.
        // For MongoDB, you typically don't need migrations.
        // However, you can use this migration to set up indexes or seed data.
        
        Schema::connection('mongodb')->create('posts', function ($collection) {
            $collection->index('title'); // Example of creating an index for 'title'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('posts');
    }
}
