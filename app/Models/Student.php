<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'phone'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'student_courses');
    }
}
