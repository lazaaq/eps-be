<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonInteractive extends Model
{
    public $timestamps = true;
    protected $fillable = ['package_id','type','name','description','file_url'];
    protected $guarded = ['created_at', 'updated_at'];

    public function package()
    {
        return $this->belongsTo('App\Package', 'package_id', 'id');
    }

}
