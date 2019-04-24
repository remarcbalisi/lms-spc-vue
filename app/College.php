<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use SoftDeletes;

    protected $table = 'colleges';
    protected $fillable = [
        'name', 'slug'
    ];
}
