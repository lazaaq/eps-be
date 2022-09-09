<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\User;
use App\Collager;
use App\QuizCollager;
use App\QuizType;
use App\Package;
use App\Transaction;
use App\TransactionDetail;
use Auth;
use DB;
use Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Lib\Helper;

class UserPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {
            return view('user-package.index');
        }

        public function getData(Request $request)
        {
            $lpk = Auth::user()->lpk;
            $data = User::whereHas("roles", function($q) {
                $q->where("name", "user");
            })
            ->when($lpk, function ($query, $lpk) {
                return $query->where('lpk', $lpk);
            })
            ->with('collager.transaction.transactionDetail')->get();
            return datatables()->of($data)
            ->addColumn('action', function($row){
                $btn = '<a title="Tambah Paket" href="'.route('user-package.edit',$row->id).'" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon btn-block">Tambah Paket</a>';
                $btn = $btn.'<a title="Riwayat Pengerjaan" id="btn-detail" href="'.route('history.show',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon btn-block">Riwayat</a>';
                // $btn = $btn.'  <a title="Ubah Data Akun" href="'.route('user-package.edit',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
                // $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
                return $btn;
            })
            ->addColumn('password_show', function($row){
                if(Hash::check($row->password_default,$row->password)){
                    return $row->password_default;
                }
                else{
                    return '<span class="label label-default">Sudah Diganti</span>';
                }
            })
            ->addColumn('package_name', function($row){
                $package = '';
                foreach ($row->collager->transaction as $key => $value) {
                    $key%2 == 0 ? $color = 'violet' : $color ='indigo';
                    $package = $package.'<span class="label border-left-'.$color.' label-striped" style="margin:2px 0px 2px 0px">';
                    foreach ($value->transactionDetail as $key => $value2) {
                        $package = $package.$value2->package->quizType->quizCategory->name.' - '.$value2->package->quizType->name.'<br>';
                    }
                    $package = $package.'</span><br>';
                }
                return $package;
            })
            ->rawColumns(['action','password_show','package_name'])
            ->make(true);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            if (Auth::user()->lpk) {
                $role = Role::orderBy('id', 'desc')->whereNotIn('id',[1])->get();
                $package = QuizType::with('package')
                ->has('package')
                ->where('lpk',Auth::user()->lpk)
                ->get();
            } else {
                $role = Role::orderBy('id', 'desc')->get();
                $package = QuizType::with('package')
                ->has('package')
                ->get();
            }
            return view('user-package.create',compact(['role','package']));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function store(Request $request)
        {
            $this->validate(request(),
                [
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'lpk' => 'required',
                ]
            );

            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = \Hash::make($request->password);
            $user->password_default = $request->password;
            $user->picture = 'avatar.png';
            $user->lpk = $request->lpk;
            $user->save();
            $user->roles()->sync(2);

            $collager = new Collager();
            $collager->user_id = $user->id;
            $collager->save();

            $newTransactionId = 'TR'.Carbon::now()->format('ymdHis').rand(100,999);
            $transaction = new Transaction;
            $transaction->id = $newTransactionId;
            $transaction->collager_id = $collager->id;
            $transaction->unique_payment = 0;
            $transaction->payment_method = 'PAYMENT_METHOD_0';
            $transaction->status = 'STATUS_TRANS_2'; //PAYMENT CONFIRMED
            $transaction->start_date   = Carbon::now();
            $transaction->expired_date = Carbon::now()->addMonths(6);
            $transaction->save();

            foreach ($request->paket as $key => $value) {
                $transactionDetail = new TransactionDetail;
                $transactionDetail->id = 'DTR'.Carbon::now()->format('ymdHi').rand(1000,9999);
                $transactionDetail->transaction_id = $newTransactionId;
                $transactionDetail->package_id = $value;
                $transactionDetail->price = Package::find($value)->price;
                $transactionDetail->save();
            }

            $amount_paid = TransactionDetail::where('transaction_id',$newTransactionId)->sum('price');
            $transaction = Transaction::find($newTransactionId);
            $transaction->amount_paid = $amount_paid;
            $transaction->save();

            DB::commit();

            return redirect()->route('user-package.index');
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function show($id)
        {
            $data = User::with('roles')->find($id);
            return view('user-package.profile',compact('data'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function edit($id)
        {
            $data = User::find($id);
            if (Auth::user()->lpk) {
                $role = Role::orderBy('id', 'desc')->whereNotIn('id',[1])->get();
            } else {
                $role = Role::orderBy('id', 'desc')->get();
            }
            /* START package yang sudah dibeli */
            $package_bought = TransactionDetail::whereHas("transaction", function($q) use ($data) {
                $q->where("collager_id", $data->collager->id);
            })->get()->pluck('package_id');
            /* END package yang sudah dibeli */
            $package = QuizType::with('package')
            ->has('package')
            ->where('lpk',$data->lpk)
            ->whereHas("package", function($q) use ($package_bought) {
                $q->whereNotIn('id',$package_bought);
            })
            ->get();
            return view('user-package.edit',compact('data','role','package'));
        }

        public function picture($id)
        {
            $user = User::find($id);
            return \Image::make(\Storage::get('public/images/user/'.$user->picture))->response();
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function update(Request $request, $id)
        {
            $this->validate(request(),
            [
                'username' => 'required|unique:users,username,'.$id,
                'email' => 'required|unique:users,email,'.$id,
                'lpk' => 'required',
                ]
            );

            DB::beginTransaction();
            $user = User::find($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->password) {
                $user->password_default = $request->password;
                $user->password = \Hash::make($request->password);
            }
            $user->lpk = $request->lpk;
            $user->save();

            if ($request->paket) {
                $newTransactionId = 'TR'.Carbon::now()->format('ymdHis').rand(100,999);
                $transaction = new Transaction;
                $transaction->id = $newTransactionId;
                $transaction->collager_id = $user->collager->id;
                $transaction->unique_payment = 0;
                $transaction->payment_method = 'PAYMENT_METHOD_0';
                $transaction->status = 'STATUS_TRANS_2'; //PAYMENT CONFIRMED
                $transaction->start_date   = Carbon::now();
                $transaction->expired_date = Carbon::now()->addMonths(6);
                $transaction->save();

                foreach ($request->paket as $key => $value) {
                    $transactionDetail = new TransactionDetail;
                    $transactionDetail->id = 'DTR'.Carbon::now()->format('ymdHi').rand(1000,9999);
                    $transactionDetail->transaction_id = $newTransactionId;
                    $transactionDetail->package_id = $value;
                    $transactionDetail->price = Package::find($value)->price;
                    $transactionDetail->save();
                }

                $amount_paid = TransactionDetail::where('transaction_id',$newTransactionId)->sum('price');
                $transaction = Transaction::find($newTransactionId);
                $transaction->amount_paid = $amount_paid;
                $transaction->save();
            }
            DB::commit();
            return redirect()->route('user-package.index');
        }

        public function updateProfil(Request $request, $id)
        {
            $this->validate(request(),
            [
                'name' => 'required',
                'username' => 'required|unique:users,username,'.$id,
                'email' => 'required|unique:users,email,'.$id,
                'picture' => 'max:2048|mimes:png,jpg,jpeg',
            ]
            );

            $user = User::find($id);

            if(!empty($request->picture)){
            $file = $request->file('picture');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = uniqid() . '.' . $extension;
            \Storage::delete('public/images/user/' . $user->picture);
            \Storage::put('public/images/user/' . $filename, \File::get($file));
            } else {
            $filename = $user->picture;
            }

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->password) {
            $user->password = \Hash::make($request->password);
            }
            $user->picture = $filename;
            $user->save();
            return redirect()->route('user-package.show',$id);
        }

        public function updatePassword(Request $request, $id)
        {
            $this->validate(request(),
            [
                'password' => 'confirmed'
            ]
            );

            $user = User::find($id);
            if ($request->password) {
            $user->password = \Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('user-package.show',$id);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy($id)
        {
            $user = User::find($id);
            \Storage::delete('public/images/user/'.$user->picture);
            $user->delete();

            return response()->json(['data'=>'success delete data']);
        }
}
