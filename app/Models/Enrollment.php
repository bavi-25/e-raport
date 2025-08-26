<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    //
    protected $table = 'enrollments';
    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year_id',
        'tenant_id'
    ];
    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }
    public function class(){
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function academicYear(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
    public function tenant(){
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
