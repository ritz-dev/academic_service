<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','teacher_id','academic_year_id'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
