<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Instructor;
use Validator;
use File;
use Cache;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(){
        $data = Instructor::all()->sortBy('name');
        return datatables()->of($data)
        ->addColumn('action', function($row){
            $btn = '<a title="Schedule" id="schedule" class="btn border-violet btn-xs text-violet-600 btn-flat btn-icon"><i class="icon-calendar"></i></a>';
            $btn = $btn.'  <a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
            $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('picture', function($row){
          $time = \Carbon\Carbon::now();
          if ($row->picture == 'blank.jpg') {
            $picture = '<img class="img-responsive" src="'.asset('img/blank.jpg').'" alt="instructor" title="instructor" width="100px" style="border-radius:50%">';
          } else {
            $row->picture = route('instructor.picture',$row->id);
            $picture = '<img class="img-responsive" src="'.route('instructor.picture',$row->id).'?'.$time.'" alt="instructor" title="instructor" width="100px" style="border-radius:50%">';
          }
          return $picture;
        })
        ->rawColumns(['action','picture'])
        ->make(true);
    }

    public function index()
    {
        return view('instructor.index');
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
        $rules = [
            'name' => 'required|max:150|unique:instructors',
            'picture' => 'max:2048|mimes:png,jpg,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->all()]);
            }
        else{
            if(!empty($request->picture)){
                $file = $request->file('picture');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = $request->name . '.' . $extension;
                Storage::put('public/images/instructor/' . $filename, File::get($file));
            } else {
                $filename='blank.jpg';
            }
            Instructor::create(
                [
                    'name' => request('name'),
                    'picture'=>$filename
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
        $data = Instructor::find($id);
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
        $data= Instructor::find($id);
        $rules = [
        'name_edit' => 'required|max:150|unique:instructors,name,'.$data->id.',id',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
        if(!empty($request->picture_edit)){
            $file = $request->file('picture_edit');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = $request->name_edit . '.' . $extension;
            Storage::delete('public/images/instructor/' . $data->picture);
            Storage::put('public/images/instructor/' . $filename, File::get($file));
        }else{
            $filename=$data->picture;
        }
        $data->name=$request->name_edit;
        $data->picture=$filename;
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
        $data = Instructor::find($id);
        Storage::delete('public/images/instructor/'.$data->pic_url);
        $data->delete();

        return redirect()->route('instructor.index');
    }

    public function picture($id)
    {
        $data = Cache::remember('instructor'.$id, 24*60, function() use ($id) {
            return Instructor::find($id)->picture;
        });
        return Image::make(Storage::get('public/images/instructor/'.$data))->response();
    }
}
