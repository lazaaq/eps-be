<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Lpk;
use Validator;
use File;
use Auth;
use Carbon\Carbon;

class LpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData()
    {
        $data = Lpk::all()->sortBy('name');
        return datatables()->of($data)->addColumn('action', function($row){
            $btn = '<a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
            $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function index()
    {
        return view('lpk.index');
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
            'name' => 'required',
            'address' => 'max:150',
            'phone_number' => 'max:15|digits_between:12,15',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            Lpk::create(
                [
                    'id' => 'LPK'.Carbon::now()->format('ymdHi').rand(100,999),
                    'name' => request('name'),
                    'address' => request('address'),
                    'phone_number'=>request('phone_number'),
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
        $data = Lpk::find($id);
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
        $data= Lpk::find($id);
        $rules = [
            'name_edit' => 'required',
            'address_edit' => 'max:150',
            'phone_number_edit' => 'max:15|digits_between:12,15',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $data->name=$request->name_edit;
            $data->address=$request->address_edit;
            $data->phone_number=$request->phone_number_edit;
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
        $data = Lpk::find($id)->delete();
        return redirect()->route('lpk.index');
    }
}
