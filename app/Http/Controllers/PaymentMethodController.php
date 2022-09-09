<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Component;
use Validator;
use File;
use Auth;
use Carbon\Carbon;

class PaymentMethodController extends Controller
{
    public function getData()
    {
        $data = Component::where('code_group','PAYMENT_METHOD')->get()->sortBy('name');
        return datatables()->of($data)->addColumn('action', function($row){
            $btn = '<a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
            $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('logo', function($row){
          if ($row->note2) {
            $picture = '<img class="img-responsive" src="'.asset('storage/images/payment-method/'.$row->note2.'').'" alt="payment" title="Payment Method Logo" width="100%">';
          } else {
              $picture = null;
          }
          return $picture;
        })
        ->rawColumns(['action','logo'])
        ->make(true);
    }
    public function index()
    {
        return view('payment-method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'account_name' => 'required|max:50',
            'owner' => 'required|max:50',
            'id_number' => 'required|digits_between:1,50',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if(!empty($request->logo)){
                $file = $request->file('logo');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = Carbon::now()->format('ymdHi').rand(100,999) . '.' . $extension;
                Storage::put('public/images/payment-method/' . $filename, File::get($file));
            } else {
                $filename=null;
            }
            Component::create(
                [
                    'com_cd' => 'PAYMENT_METHOD_'.rand(100,999),
                    'code_nm' => request('account_name'),
                    'code_group' => 'PAYMENT_METHOD',
                    'code_value'=>request('id_number'),
                    'note' => request('owner'),
                    'note2'=>$filename,
                    'created_by'=>Auth::user()->id,
                ]
            );
            return response()->json(['success'=>'Data added successfully']);
        }
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
        $data = Component::where('com_cd',$id)->first();
        if ($data->note2) {
            $data->logo = '<img class="img-responsive mb-2" src="'.asset('storage/images/payment-method/'.$data->note2.'').'" alt="payment" title="Payment Method Logo" width="50%">';
        } else {
            $data->logo = null;
        }
        return response()->json(['status' => 'ok','data'=>$data],200);
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
        $data = Component::where('com_cd',$id)->first();
        $rules = [
            'account_name_edit' => 'required|max:50',
            'owner_edit' => 'required|max:50',
            'id_number_edit' => 'required|digits_between:1,50',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if(!empty($request->logo_edit)){
                $file = $request->file('logo_edit');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = Carbon::now()->format('ymdHi').rand(100,999) . '.' . $extension;
                Storage::delete('public/images/payment-method/' . $data->note2);
                Storage::put('public/images/payment-method/' . $filename, File::get($file));
            }else{
                $filename=$data->note2;
            }
            $data->code_nm = request('account_name_edit');
            $data->code_value = request('id_number_edit');
            $data->note = request('owner_edit');
            $data->note2 = $filename;
            $data->updated_by=Auth::user()->id;
            $data->save();
            return response()->json(['success'=>'Data updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Component::where('com_cd',$id)->first();
        Storage::delete('public/images/payment-method/'.$data->note2);
        $data->delete();
        return redirect()->route('payment-method.index');
    }
}
