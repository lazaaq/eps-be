<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'instructors';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];

    public function scheduleDetail()
    {
        return $this->hasMany('App\ScheduleDetail', 'instructor_id', 'id');
    }
}
