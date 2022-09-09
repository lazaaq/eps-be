<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public static function getProofOfPayment($transaksi_id){
        $data = Transaction::find($transaksi_id);
        if ($data->proof_of_payment) {
            $url = url('/').'/storage/images/proof_of_payment/'.$data->proof_of_payment;
        } else {
            $url = null;
        }
        return $url;
    }

    public function collager()
    {
        return $this->belongsTo('App\Collager', 'collager_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo('App\Package', 'package_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Component', 'payment_method', 'com_cd');
    }

    public function statusTransaction()
    {
        return $this->belongsTo('App\Component', 'status', 'com_cd');
    }

    public function transactionDetail()
    {
        return $this->hasMany('App\TransactionDetail', 'transaction_id', 'id');
    }
    

}
