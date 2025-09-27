<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentItem extends Model
{
    //
    protected $table = 'assessment_items';
    protected $fillable = [
        'assessment_id',
        'tenant_id',
        'competency_code',
        'max_score',
    ];
    protected $casts = [
        'max_score' => 'decimal:2',
    ];
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }
    public function component()
    {
        return $this->belongsTo(\App\Models\AssessmentComponent::class, 'component_id');
    }
    public function gradeEntries()
    {
        return $this->hasMany(\App\Models\GradeEntry::class, 'assessment_item_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
