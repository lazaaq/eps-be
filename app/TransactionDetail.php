<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function transaction()
    {
        return $this->belongsTo('App\Transaction', 'transaction_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo('App\Package', 'package_id', 'id');
    }
}
