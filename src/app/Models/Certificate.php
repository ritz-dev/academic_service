<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = ['student_id','certificate_type','issue_date','expiry_date','issued_by','result','additional_details','academic_year_id'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
