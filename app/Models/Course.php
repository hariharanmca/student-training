<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','duration','created_at','updated_at'];

    public function students() {
        return $this->belongsToMany(Student::class, 'student_courses');
    }
}
