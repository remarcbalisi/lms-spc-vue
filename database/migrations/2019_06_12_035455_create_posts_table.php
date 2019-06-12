<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('title', 45);
            $table->longText('body');
            $table->bigInteger('classroom_id')->nullable();

            $table->unsignedBigInteger('post_type_id')->onDelete('set null')->nullable();
            $table->unsignedBigInteger('post_category_id')->onDelete('set null')->nullable();
            $table->unsignedBigInteger('posted_by');

            $table->foreign('post_type_id')->references('id')->on('post_types');
            $table->foreign('post_category_id')->references('id')->on('post_categories');
            $table->foreign('posted_by')->references('id')->on('users');
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
