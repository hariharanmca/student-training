<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentTraining extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','schedule_id','status'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function trainingSchedule() {
        return $this->belongsTo(TrainingSchedule::class, 'schedule_id');
    }
}
