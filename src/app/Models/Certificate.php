<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = ['student_id','certificate_type','issue_date','expiry_date','issued_by','additional_details','grade_details'];

    protected $hidden = ["created_at","updated_at","deleted_at"];

    protected $casts = [
        'grade_details' => 'array',  // Automatically cast grade details to array
    ];
}