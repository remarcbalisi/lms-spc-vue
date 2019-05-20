<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $table = 'classrooms';

    protected $fillable = [
        'section_id', 'subject_id', 'academic_yr_semester_id'
    ];

    public function section() {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function academic_yr_semester() {
        return $this->belongsTo('App\AcademicYrSemester', 'academic_yr_semester_id');
    }

    public function getFullName() {
        return $this->subject()->first()->name . ' ' . $this->section()->first()->name . ', ' . $this->academic_yr_semester()->first()->getFullName();
    }

    public function classroom_users() {
        return $this->hasMany('App\ClassroomUser', 'classroom_id', 'id');
    }
}
