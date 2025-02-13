<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'start_time', 'end_time'];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
