<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizType extends Model
{
    use SoftDeletes;

    protected $table = 'quiz_types';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function quiz()
    {
        return $this->hasOne('App\Quiz', 'quiz_type_id', 'id');
    }

    public function package()
    {
        return $this->hasMany('App\Package', 'quiz_type_id', 'id');
    }

    public function quizCategory()
    {
        return $this->belongsTo('App\QuizCategory', 'quiz_category_id', 'id');
    }

    public function lpk()
    {
        return $this->belongsTo('App\Lpk', 'lpk', 'id');
    }
}
