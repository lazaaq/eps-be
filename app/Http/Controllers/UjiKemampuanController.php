<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\UjiKemampuan;
use Validator;
use App\Traits\ResponseAPI;


class UjiKemampuanController extends Controller
{
    use ResponseAPI;

    public function getData()
    {
        $data = UjiKemampuan::all()->sortBy('name');
        return datatables()->of($data)
        ->addColumn('action', function($row){
        $btn = '<a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
        $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
        return $btn;
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function index()
    {
        return view('uji-kemampuan.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'min_score' => 'required|lt:max_score|not_between',
            'max_score' => 'required|gt:min_score|not_between'
        ];

        Validator::extend('not_between', function($attribute, $value, $parameters)
        {
            $count = UjiKemampuan::where('min_score','<=',$value)->where('max_score','>=',$value)->count();
            return $count == 0;
        });

        Validator::replacer('not_between', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , 'The '. $attribute .' is already in range another data.');
        });

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $data = new UjiKemampuan;
            $data->name = $request->name;
            $data->min_score = $request->min_score;
            $data->max_score = $request->max_score;
            $data->description = $request->description;
            $data->save();
            return response()->json(['success'=>'Data added successfully']);
        }
    }

    public function edit($id)
    {
        $data = UjiKemampuan::find($id);
        return response()->json(['status' => 'ok','data'=>$data],200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name_edit' => 'required',
            'min_score_edit' => 'required|lt:max_score_edit|not_between:'.$id,
            'max_score_edit' => 'required|gt:min_score_edit|not_between:'.$id
        ];

        Validator::extend('not_between', function($attribute, $value, $parameters)
        {
            $count = UjiKemampuan::where('id','!=',$parameters[0])->where('min_score','<=',$value)->where('max_score','>=',$value)->count();
            return $count == 0;
        });

        Validator::replacer('not_between', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , 'The '. $attribute .' is already in range another data.');
        });

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $data = UjiKemampuan::find($id);
            $data->name = $request->name_edit;
            $data->min_score = $request->min_score_edit;
            $data->max_score = $request->max_score_edit;
            $data->description = $request->description_edit;
            $data->save();
            return response()->json(['success'=>'Data updated successfully']);
        }
    }

    public function destroy($id)
    {
        $data = UjiKemampuan::findOrFail($id);
        $data->delete();
    }

    // START OF API

    public function storeUjiKemampuan(Request $request)
    {
        $score = 0;
        foreach ($request->question as $value) {
            if ($value['trueAnswer'] == $value['userAnswer']) {
                $score += 1;
            }
        }

        try {
            $hasil = UjiKemampuan::where('min_score','<=',$score)->where('max_score','>=',$score)->first();
            $response = $hasil->name;
        } catch (\Throwable $th) {
            $response = 'Belum diketahui nih';
        }

        return $this->success("Hasil uji kemampuan", $response);
    }
}
