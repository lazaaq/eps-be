<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'components';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = 'com_cd';
    protected $keyType = 'string';
}
