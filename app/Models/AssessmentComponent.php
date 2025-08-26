<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentComponent extends Model
{
    //
    protected $table = 'assessment_components';
    protected $fillable = [
        'name',
        'weight',
        'tenant_id'
    ];
    protected $casts = [
        'weight' => 'decimal:2',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
