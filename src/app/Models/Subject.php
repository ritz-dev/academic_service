<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = ["name","code","description","academic_class_id"];

    protected $hidden = ["created_at","updated_at","deleted_at"];
}
