<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    //
    protected $table = 'classes';
    protected $fillable = [
        'name',
        'section',
        'label',
        'academic_year_id',
        'grade_level_id',
        'tenant_id',
        'homeroom_teacher_id'
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id', 'tenants');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id', 'academic_year');
    }
    public function gradeLevel(){
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id', 'grade_levels');
    }
    public function homeroomTeacher(){
        return $this->belongsTo(Profile::class, 'homeroom_teacher_id', 'id', 'profiles');
    }   
}
