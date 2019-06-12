<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title', 'body', 'post_type_id', 'user_id', 'classroom_id', 'post_category_id'
    ];
}
