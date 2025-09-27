<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
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
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Profile::class, 'homeroom_teacher_id');
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class, 'class_id', 'id');
    }
}

