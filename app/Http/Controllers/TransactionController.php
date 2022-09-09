<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Transaction;
use App\TransactionDetail;
use App\Package;
use App\Component;
use Validator;
use Carbon\Carbon;
use DB;
use Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ResponseAPI;

    public function index()
    {
        return view('transaction.index');
    }

    public function getData()
    {
        $data = Transaction::with('paymentMethod','transactionDetail.package.quizType.quizCategory','collager.user','statusTransaction')
        ->whereHas('transactionDetail.package.quizType', function ($query){
            if (Auth::user()->lpk) {
                $query->where('lpk', Auth::user()->lpk);
            }
        })->get()->sortBy('created_at');

        return datatables()->of($data)
        ->addColumn('action', function($row){
            $btn = '';
            if ($row->proof_of_payment) {
                $btn = '<a title="Proof of Payment" href="'.$row->getProofOfPayment($row->id).'" data-popup="lightbox" rel="gallery" class="btn border-indigo btn-xs text-indigo-600 btn-flat btn-icon"><i class="icon-wallet"></i></a>   ';
            }
            $btn = $btn.'<a id="btn-edit" title="Edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>  ';
            $btn = $btn.'<button id="delete" title="Delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('valid', function($row){
            if ($row->status == 'STATUS_TRANS_1' || $row->status == 'STATUS_TRANS_3') {
                return '<span class="label border-right-danger label-striped label-striped-right">Not Valid<br>'.$row->statusTransaction->code_nm.'</span>';
            }
            elseif ($row->status == 'STATUS_TRANS_2') {
                if ($row->start_date <= Carbon::now() && $row->expired_date >= Carbon::now()) {
                    return '<span class="label border-right-success label-striped label-striped-right">Valid<br>'.Carbon::parse($row->expired_date)->format('j F Y, H:i').'</span>';
                } else {
                    return '<span class="label border-right-danger label-striped label-striped-right">Not Valid (Expired)<br>'.Carbon::parse($row->expired_date)->format('j F Y, H:i').'</span>';
                }
            }
        })
        ->addColumn('package_name', function($row){
            $package = '<span class="label border-left-violet label-striped">';
            foreach ($row->transactionDetail as $key => $value) {
                $package = $package.$value->package->quizType->quizCategory->root.' - '.$value->package->quizType->quizCategory->name.' - '.$value->package->quizType->name.'<br>';
            }
            $package = $package.'</span></td>';
            return $package;
        })
        ->addColumn('amount', function($row){
          $amount = 'Rp '.number_format($row->amount_paid,0,".",".");
          return $amount;
        })
        ->addColumn('bank_amount', function($row){
          $bank     = $row->paymentMethod->code_nm;
          $amount   = 'Rp '.number_format($row->amount_paid,0,".",".");
          return $bank .'<br>'. $amount;
        })
        ->addColumn('status_transaksi', function($row){
            // START CEK VALID
            if ($row->status == 'STATUS_TRANS_2') {
                if ($row->start_date <= Carbon::now() && $row->expired_date >= Carbon::now()) {
                    $valid = '<span style="width:170px" class="label border-right-success label-striped label-striped-right">Valid<br>'.Carbon::parse($row->expired_date)->format('j F Y, H:i').'</span>';
                } else {
                    $valid = '<span style="width:170px" class="label border-right-danger label-striped label-striped-right">Not Valid (Expired)<br>'.Carbon::parse($row->expired_date)->format('j F Y, H:i').'</span>';
                }
            } else {
                $valid = '<span style="width:170px" class="label border-right-danger label-striped label-striped-right">Not Valid<br>'.$row->statusTransaction->code_nm.'</span>';
            }
            // END CEK VALID
            // START CEK STATUS
            $components = Component::where('code_group','TRANS')->get()->sortBy('code_value');
            $list = '';
            foreach ($components as $key => $component) {
                $status = $row->status == $component->com_cd ? "active":"";
                $list = $list.'<li class="'.$status.'"><a class="status-item" data-value="'.$component->com_cd.'">'.$component->code_nm.'</a></li>';
            }
            switch ($row->status) {
                case 'STATUS_TRANS_1':
                    $color = "bg-warning";
                    break;
                case 'STATUS_TRANS_2':
                    $color = "bg-success";
                    break;
                case 'STATUS_TRANS_3':
                    $color = "bg-danger";
                    break;
                default:
                    $color = "btn-primary";
                    break;
            }
            $btn = '<div class="btn-group" style="margin-top:5px">
                        <a class="label '.$color.' dropdown-toggle" data-toggle="dropdown" style="width:170px">'.$row->statusTransaction->code_nm.'<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right">'
                            .$list.
                        '</ul>
                    </div>';
            // END CEK STATUS
            return $valid.'<br>'.$btn;
        })
        ->rawColumns(['action','valid','package_name','amount','status_transaksi','bank_amount'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data= Transaction::find($id);
        $rules = [
            'start_date' => 'required',
            'expired_date' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data->start_date=$request->start_date;
        $data->expired_date=$request->expired_date;
        $data->payment_method=$request->payment_method;
        $data->status=$request->status;
        $data->save();

        return response()->json(['success'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Transaction::find($id)->delete();
        return response()->json(['status' => 'success', 'data'=>'Data deleted.']);
    }

    public function changeDataStatus(Request $request, $id)
    {
        $data= Transaction::find($id);
        if ($data->status == $request->status) {
            return response()->json(['status' => 'failed', 'message'=>'Nothing changed.']);
        }
        /* START  STATUSNYA DIUBAH KE CONFIRMED */
        elseif ($request->status == 'STATUS_TRANS_2') {
            $data->status = $request->status;
            $data->start_date   = Carbon::now();
                /* EXPIRED QUIZ BERBAYAR (1 minggu) */
            if (!$data->package) {
                $data->expired_date = Carbon::now()->addDays(7);
            }
            elseif ($data->package->nonInteractive->count() > 0) {
                /* EXPIRED NON INTERACTIVE (1 minggu) */
                $data->expired_date = Carbon::now()->addDays(7);
            } elseif ($data->package->scheduleDetail->count() > 0) {
                /* EXPIRED PRIVATE GROUP (ikut data jadwal terakhir) */
                $data->expired_date = Carbon::parse($data->package->scheduleDetail->max('schedule'))->addDays(1);
            }
            $data->save();
            return response()->json(['status' => 'success', 'data'=>'Status and time valid changed.']);
        } 
        /* END STATUSNYA DIUBAH KE CONFIRMED */
        else {
            $data->status = $request->status;
            $data->save();
            return response()->json(['status' => 'success', 'data'=>'Status changed.']);
        }
    }

    // START OF API

    function api_store(Request $request){
        $request->validate([
            'package' => 'required',
            'payment_method' => 'required',
        ]);
        DB::beginTransaction();

        // CEK USER DAH BELI PACKAGE NYA ATAU BELUM
        $check_userOnPack = TransactionDetail::with('transaction.statusTransaction')
        ->whereHas('transaction', function ($query){
            $query->where('collager_id',Auth::user()->collager->id);
        })
        ->where('package_id',$request->package)->latest()->first();
        if ($check_userOnPack) {
            // CEK STATUS TRANSAKSI KALO UDAH AKTIF DAN APAKAH VALID WAKTUNYA
            if ( ($check_userOnPack->transaction->status == 'STATUS_TRANS_2') && ($check_userOnPack->transaction->start_date <= Carbon::now()) && ($check_userOnPack->transaction->expired_date >= Carbon::now()) ) {
                return $this->success("Paket yang anda pilih masih aktif", $check_userOnPack->transaction);
            }
            // CEK STATUS TRANSAKSI KALO MASIH WAITING
            elseif ($check_userOnPack->transaction->status == 'STATUS_TRANS_1') {
                return $this->success("Anda telah membeli paket yang dipilih, upload bukti pembayaran, lalu tunggu dikonfirmasi admin", $check_userOnPack->transaction);
            } 
            // CEK STATUS TRANSAKSI KALO TINGGAL DI CONFIRM ADMIN
            elseif ($check_userOnPack->transaction->status == 'STATUS_TRANS_4') {
                return $this->success("Anda telah membeli paket yang dipilih, tunggu pembayaran dikonfirmasi admin", $check_userOnPack->transaction);
            }
        }
        $newID = 'TR'.Carbon::now()->format('ymdHis').rand(100,999);
        $data = new Transaction;
        $data->id = $newID;
        $data->collager_id = Auth::user()->collager->id;
        $data->unique_payment = rand(100,999);
        $data->payment_method = $request->payment_method;
        $data->status = 'STATUS_TRANS_1'; //WAITING PAYMENT
        $data->amount_paid = \App\Package::find($request->package)->price - 1000 + $data->unique_payment;
        $data->save();

        $dataDetail = new TransactionDetail;
        $dataDetail->id = 'DTR'.Carbon::now()->format('ymdHi').rand(1000,9999);
        $dataDetail->transaction_id = $newID;
        $dataDetail->price = \App\Package::find($request->package)->price;
        $dataDetail->package_id = $request->package;
        $dataDetail->save();

        DB::commit();
        $data = Transaction::with('transactionDetail.package.quizType.quizCategory','paymentMethod','statusTransaction')->find($data->id);
        return $this->success("Transaksi berhasil dibuat", $data);
    }

    public function api_uploadBuktiTransfer($id, Request $request){
        $data = Transaction::find($id);
        $validator = Validator::make($request->all(), [
            'proof_of_payment' => 'max:2056',
        ]);
        if ($request->proof_of_payment) {
            $file = $request->file('proof_of_payment');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = Carbon::now()->format('ymdHis').rand(100,999) . '.' . $extension;
            \Storage::put('public/images/proof_of_payment/' . $filename, \File::get($file));
            $data->proof_of_payment = $filename;
        }
        $data->status = "STATUS_TRANS_4";
        $data->save();

        $data = Transaction::with('transactionDetail.package.quizType.quizCategory','paymentMethod','statusTransaction')->find($data->id);
        $data->proof_of_payment_url = $data->getProofOfPayment($data->id);
        return $this->success("Payment confirmed.", $data);
    }

    function api_list(){
        $data = Transaction::with('transactionDetail.package.quizType.quizCategory','paymentMethod','statusTransaction')->where('collager_id',Auth::user()->collager->id)->get()->sortByDesc('created_at');
        foreach ($data as $key => $value) {
            $value->proof_of_payment_url = $value->getProofOfPayment($value->id);
        }
        return $this->success("Transaksi List", $data);
    }

    function api_show($id){
        $data = Transaction::with('transactionDetail.package.quizType.quizCategory','paymentMethod','statusTransaction')->find($id);
        $data->proof_of_payment_url = $data->getProofOfPayment($data->id);
        return $this->success("Transaksi Detail", $data);
    }

    function api_statusFailed($id){
        DB::beginTransaction();
        $data = Transaction::find($id);

        // CEK STATUS TRANSAKSI KALO MASIH AKTIF DAN VALID WAKTUNYA
        if ($data->status == 'STATUS_TRANS_2') {
            return $this->success("Transaksi anda sudah terkonfirmasi dan tidak bisa digagalkan", $data);
        } elseif ($data->status == 'STATUS_TRANS_4') {
            return $this->success("Transaksi anda sedang menunggu konfirmasi dan tidak bisa digagalkan", $data);
        }

        $data->status = 'STATUS_TRANS_3'; //FAILED
        $data->save();
        DB::commit();
        $data = Transaction::with('transactionDetail.package.quizType.quizCategory','paymentMethod','statusTransaction')->find($data->id);
        $data->proof_of_payment_url = $data->getProofOfPayment($data->id);
        return $this->success("Transaksi Dibatalkan", $data);
    }

    function api_cekStatus($id){
        // CEK USER DAH BELI PACKAGE NYA ATAU BELUM
        $check_userOnPack = TransactionDetail::with('transaction.statusTransaction')
        ->whereHas('transaction', function ($query){
            $query->where('collager_id',Auth::user()->collager->id);
        })
        ->where('package_id',$id)->latest()->first();
        
        $check_userOnPack->transaction->proof_of_payment_url = $check_userOnPack->transaction->getProofOfPayment($check_userOnPack->transaction->id);
        if ($check_userOnPack) {
            // CEK STATUS TRANSAKSI KALO MASIH WAITING
            if ($check_userOnPack->transaction->status == 'STATUS_TRANS_1') {
                $status = ['beli'=>'1','pembayaran'=>'0','time_valid'=>'0'];
                return $this->success($status, $check_userOnPack->transaction);
            }
            elseif ($check_userOnPack->transaction->status == 'STATUS_TRANS_4') {
                $status = ['beli'=>'1','pembayaran'=>'1','time_valid'=>'0'];
                return $this->success($status, $check_userOnPack->transaction);
            }
            // CEK STATUS TRANSAKSI KALO UDAH AKTIF
            elseif ($check_userOnPack->transaction->status == 'STATUS_TRANS_2') {
                // CEK STATUS TRANSAKSI KALO VALID WAKTUNYA
                if ($check_userOnPack->transaction->start_date <= Carbon::now() && $check_userOnPack->transaction->expired_date >= Carbon::now()) {
                    $status = ['beli'=>'1','pembayaran'=>'1','time_valid'=>'1'];
                    return $this->success($status, $check_userOnPack->transaction);
                } else {
                    $status = ['beli'=>'1','pembayaran'=>'1','time_valid'=>'0'];
                    return $this->success($status, $check_userOnPack->transaction);
                }
            }
        } else {
            $status = ['beli'=>'0','pembayaran'=>'0','time_valid'=>'0'];
            return $this->success($status, Package::find($id));
        }
    }
}
