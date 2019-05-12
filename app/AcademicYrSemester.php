<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AcademicYrSemester extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'academic_yr_semesters';

    protected $fillable = [
        'academic_year_id', 'semester_id', 'is_active',
    ];

    public function academic_year() {
        return $this->belongsTo('App\AcademicYear', 'academic_year_id');
    }

    public function semester() {
        return $this->belongsTo('App\Semester', 'semester_id');
    }

    public function getFullName() {
        return 'AY ' . $this->academic_year()->first()->from_date . '-' . $this->academic_year()->first()->to_date . ', ' . $this->semester()->first()->name . ' semester';
    }

}
