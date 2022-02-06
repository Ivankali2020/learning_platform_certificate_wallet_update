<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
//    protected $with=['category','user','curriculums'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function curriculums()
    {
        return $this->hasMany(CourseCurriculum::class);
    }

    public function heart()
    {
        return $this->belongsToMany(User::class);
    }


}
