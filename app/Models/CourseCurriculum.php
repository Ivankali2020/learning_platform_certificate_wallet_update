<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCurriculum extends Model
{
    use HasFactory;
//    protected $with = ['course'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
