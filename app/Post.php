<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title', 'body', 'post_type_id', 'posted_by', 'classroom_id', 'post_category_id'
    ];

    public function postedBy() {
        return $this->belongsTo('App\User', 'posted_by');
    }

    public function postType() {
        return $this->belongsTo('App\PostType', 'post_type_id');
    }

    public function postCategory() {
        return $this->belongsTo('App\PostCategory', 'post_category_id');
    }
}
