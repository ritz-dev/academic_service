<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeTable extends Model
{
    use SoftDeletes;

    protected $fillable = ['section_id','subject_id','teacher_id','day_of_week','time_start','time_end','term'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    public function class()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
