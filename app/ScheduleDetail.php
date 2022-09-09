<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];

    public function package()
    {
        return $this->belongsTo('App\Package', 'package_id', 'id');
    }
    public function instructor()
    {
        return $this->belongsTo('App\Instructor', 'instructor_id', 'id');
    }
}
