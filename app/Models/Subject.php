<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = 'subjects';
    protected $fillable = [
        'code',
        'name',
        'group_name',
        'phase',
        'tenant_id'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id', 'tenants');
    }

    public function gradeLevels()
    {
        return $this->belongsToMany(GradeLevel::class, 'grade_level_subject', 'subject_id', 'grade_level_id');
    }
}
