<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    //
    protected $table = 'class_subjects';
    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'tenant_id'
    ];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Profile::class, 'teacher_id');
    }

    public function assessments()
    {
        return $this->hasMany(\App\Models\Assessment::class, 'class_subject_id');
    }
    public function finalGrades()
    {
        return $this->hasMany(\App\Models\FinalGrade::class, 'class_subject_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_subject_id');
    }
}
