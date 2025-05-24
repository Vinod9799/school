<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'teacher_id', 'class_id', 'date', 'status',
    ];

    public function attendance()
    {
        return $this->hasOne(User::class,'id', 'student_id');
    }
     public function studentClass()
    {
        return $this->hasOne(MyClass::class,'id', 'class_id');
    }
}
