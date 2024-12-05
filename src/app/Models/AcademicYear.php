<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use SoftDeletes;

    protected $fillable = ['year','start_date','end_date','is_active'];

    protected $hidden = ["created_at","updated_at","deleted_at"];
    
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
