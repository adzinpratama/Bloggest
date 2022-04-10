<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->string('slug')->unique();
            $table->string('thumbnail')->default('no-image.jpg');
            $table->string('description', 240)->nullable();
            $table->longText('content');
            $table->string('type', 20);
            $table->enum('status', [
                'publish', 'pending', 'draft', 'star', 'trash'
            ]);
            $table->foreignUuid('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
