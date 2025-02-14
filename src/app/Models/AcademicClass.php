<?php

namespace App\Models;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClass extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','academic_year_id'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class,'id','academic_year_id');
    }
}
