<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    //
    protected $table = 'academic_year';

    protected $fillable = [
        'code',
        'term',
        'start_date',
        'end_date',
        'status',
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id', 'tenants');
    }
    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'academic_year_id', 'id', 'classes');
    }
}
