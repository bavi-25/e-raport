<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $table = 'assessments';
    protected $fillable = [
        'title',
        'date',
        'enrollment_id',
        'class_subject_id',
        'assessment_component_id',
        'tenant_id'
    ];
    protected $casts = [
        'date' => 'date',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }
    public function assessmentComponent()
    {
        return $this->belongsTo(AssessmentComponent::class, 'assessment_component_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
