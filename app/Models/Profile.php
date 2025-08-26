<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $table = 'profiles';
    protected $fillable = [
        'name',
        'nip_nis',
        'birth_date',
        'religion',
        'gender',
        'phone',
        'address',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }
    
}
