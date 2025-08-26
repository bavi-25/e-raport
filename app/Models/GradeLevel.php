<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    //
    protected $table = 'grade_levels';
    protected $fillable = [
        'name',
        'level',
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id', 'tenants');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_level_subject', 'grade_level_id', 'subject_id');
    }
    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'grade_level_id', 'id', 'classes');
    }
}
