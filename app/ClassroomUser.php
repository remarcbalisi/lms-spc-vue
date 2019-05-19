<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomUser extends Model
{
    use SoftDeletes;

    protected $table = 'classroom_users';
    protected $fillable = [
        'user_id', 'classroom_id', 'is_enrolled',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function classroom() {
        return $this->belongsTo('App\Classroom', 'classroom_id');
    }
}
