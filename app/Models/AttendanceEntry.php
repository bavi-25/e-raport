<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceEntry extends Model
{

    protected $table = 'attendance_entries';
    protected $fillable = [
        'attendance_id',
        'student_id',
        'status',
        'remarks',
        'tenant_id',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }

    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
