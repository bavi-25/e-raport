<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = 'attendance';
    protected $fillable = [
        'date',
        'class_subject_id',
        'teacher_id',
        'notes',
        'tenant_id',
    ];
    protected $casts = [
        'date' => 'date',
    ];

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Profile::class, 'teacher_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function entries()
    {
        return $this->hasMany(AttendanceEntry::class, 'attendance_id');
    }

}
