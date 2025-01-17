<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClass extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $hidden = ["created_at","updated_at","deleted_at"];
    
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'academic_class_subjects');
    }
}
