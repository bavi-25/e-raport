<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantProfile extends Model
{
    //
    protected $table = 'tenant_profiles';
    protected $fillable = [
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'principal_name',
        'principal_nip',
        'established_year',
        'latitude',
        'longitude',
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
