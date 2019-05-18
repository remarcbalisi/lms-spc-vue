<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';
    protected $fillable = [
        'offered_from', 'name', 'code', 'slug'
    ];

    public function college() {
        return $this->BelongsTo('App\College', 'offered_from', 'id');
    }
}
