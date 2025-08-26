<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeEntry extends Model
{
    //
    protected $table = 'grade_entries';
    protected $fillable = [
        'final_score',
        'student_id',
        'assessment_item_id',
        'tenant_id',
    ];
    protected $casts = [
        'final_score' => 'decimal:2',
    ];
    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }
    public function assessmentItem(){
        return $this->belongsTo(AssessmentItem::class, 'assessment_item_id');
    }
}
