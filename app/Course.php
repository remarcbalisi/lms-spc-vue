<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';
    protected $fillable = [
        'name', 'slug', 'college_id'
    ];

    public function college() {
        return $this->belongsTo('App\College', 'college_id');
    }
}
