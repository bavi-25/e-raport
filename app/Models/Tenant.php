<?php

namespace App\Models;

use App\Models\TenantProfile;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    //
    protected $table = 'tenants';
    protected $fillable = [
        'uuid',
        'name',
        'npsn',
        'level',
        'status',
    ];
    public function profile()
    {
        return $this->hasOne(TenantProfile::class, 'tenant_id');
    }
}
