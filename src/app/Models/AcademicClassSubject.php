<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClassSubject extends Model
{
    use SoftDeletes;

    protected $table = "academic_class_subjects";

    protected $fillable = [
        "academic_class_id",
        "subject_id",
    ];
}
