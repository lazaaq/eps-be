<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];

    public function scheduleDetail()
    {
        return $this->hasMany('App\ScheduleDetail', 'package_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'package_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany('App\TransactionDetail', 'package_id', 'id');
    }

    public function quizType()
    {
        return $this->belongsTo('App\QuizType', 'quiz_type_id', 'id');
    }
    public function nonInteractive()
    {
        // return $this->hasMany('App\NonInteractive', 'package_id', 'id')->select(['id','type','name','description']);
        return $this->hasMany('App\NonInteractive', 'package_id', 'id');
    }

}
