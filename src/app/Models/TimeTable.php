<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\AcademicClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeTable extends Model
{
    use SoftDeletes;

    protected $fillable = ['academic_year_id','academic_class_id','section_id','subject_id','teacher_id','date','day','start_time','end_time','type'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

}
