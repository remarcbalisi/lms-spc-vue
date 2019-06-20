<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    protected $table = 'multimedias';
    protected $fillable = [
        'type', 'directory', 'post_id', 'original_name'
    ];
}
