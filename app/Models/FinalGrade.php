<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    //
    protected $table = 'final_grades';
    protected $fillable = [
        'final_score',
        'class_subject_id',
        'student_id',
        'tenant_id',
    ];
    protected $casts = [
        'final_score' => 'decimal:2',
    ];
    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
