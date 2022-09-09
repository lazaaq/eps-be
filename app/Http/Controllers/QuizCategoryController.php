<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\QuizCategory;
use Validator;
use File;
use Auth;
use DB;

class QuizCategoryController extends Controller
{
  public function createDataDefault()
  {
    /*
    MASTER CLASS -> private, group
    KELAS BAHASA KOREA -> Non Interactive, Privat, Group
    TOPIK -> Non Interactive, Privat, Group
    EPS-TOPIK -> Non Interactive, Privat, Group, TRY OUT
    */
    DB::beginTransaction();
    DB::table('quiz_categorys')->insert(array (
      0 => 
      array (
          'root' => 'Tes Kemampuan',
          'name' => 'Tes Kemampuan',
          'description' => 'Tes Kemampuan',
          'pic_url' => NULL,
          'created_at' => '2020-11-01 10:02:27',
          'updated_at' => '2020-11-01 10:02:27',
          'deleted_at' => NULL,
      ),
      7 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 1',
          'description' => 'Level 1',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:06:37',
          'updated_at' => '2020-11-08 10:06:37',
          'deleted_at' => NULL,
      ),
      8 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 2',
          'description' => 'Level 2',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:06:37',
          'updated_at' => '2020-11-08 10:06:37',
          'deleted_at' => NULL,
      ),
      9 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 3',
          'description' => 'Level 3',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:07:30',
          'updated_at' => '2020-11-08 10:07:30',
          'deleted_at' => NULL,
      ),
      10 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 4',
          'description' => 'Level 4',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:07:30',
          'updated_at' => '2020-11-08 10:07:30',
          'deleted_at' => NULL,
      ),
      11 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 5',
          'description' => 'Level 5',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:07:30',
          'updated_at' => '2020-11-08 10:07:30',
          'deleted_at' => NULL,
      ),
      12 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 6',
          'description' => 'Level 6',
          'pic_url' => '',
          'created_at' => '2020-11-08 10:07:30',
          'updated_at' => '2020-11-08 10:03:39',
          'deleted_at' => NULL,
      ),
      13 => 
      array (
          'root' => 'Master Class Bahasa Korea',
          'name' => 'Level 7',
          'description' => 'Level 7',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:03:39',
          'updated_at' => '2020-11-08 10:03:39',
          'deleted_at' => NULL,
      ),
      14 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 1',
          'description' => 'Level 1',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      15 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 2',
          'description' => 'Level 2',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      16 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 3',
          'description' => 'Level 3',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      17 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 4',
          'description' => 'Level 4',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      18 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 5',
          'description' => 'Level 5',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      19 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 6',
          'description' => 'Level 6',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      20 => 
      array (
          'root' => 'Kursus Bahasa Korea Umum',
          'name' => 'Level 7',
          'description' => 'Level 7',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:09:29',
          'updated_at' => '2020-11-08 10:09:29',
          'deleted_at' => NULL,
      ),
      21 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 1',
          'description' => 'Level 1',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      22 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 2',
          'description' => 'Level 2',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      23 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 3',
          'description' => 'Level 3',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      24 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 4',
          'description' => 'Level 4',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      25 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 5',
          'description' => 'Level 5',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      26 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 6',
          'description' => 'Level 6',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      27 => 
      array (
          'root' => 'Kursus Topik',
          'name' => 'Level 7',
          'description' => 'Level 7',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:12:11',
          'updated_at' => '2020-11-08 10:12:11',
          'deleted_at' => NULL,
      ),
      28 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 1',
          'description' => 'Level 1',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:16:34',
          'updated_at' => '2020-11-08 10:16:34',
          'deleted_at' => NULL,
      ),
      29 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 2',
          'description' => 'Level 2',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
      30 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 3',
          'description' => 'Level 3',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
      31 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 4',
          'description' => 'Level 4',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
      32 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 5',
          'description' => 'Level 5',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
      33 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 6',
          'description' => 'Level 6',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
      34 => 
      array (
          'root' => 'Kursus Eps-Topik',
          'name' => 'Level 7',
          'description' => 'Level 7',
          'pic_url' => NULL,
          'created_at' => '2020-11-08 10:17:24',
          'updated_at' => '2020-11-08 10:17:24',
          'deleted_at' => NULL,
      ),
  ));
    DB::commit();
    return 'Success create data';
  }

  public function getData()
  {
    $lpk = Auth::User()->lpk;
    $data = QuizCategory::when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('name');
    return datatables()->of($data)
    ->addColumn('action', function($row){
      $btn = '<a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
      $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
      return $btn;
    })
    ->addColumn('lpk_name', function($row){
      if (!empty($row->lpk)) {
        return $row->lpk()->first()->name;
      } else {
        return 'Umum';
      }
    })
    ->rawColumns(['action','lpk_name'])
    ->make(true);
  }
  public function index()
  {
    return view('quiz-category.index');
  }

  public function create()
  {
    return view('quiz-category.create');
  }

  public function store(Request $request)
  {
    $rules = [
      'lpk' => 'required',
      'name' => 'required|max:150',
      // 'name' => 'required|max:150|unique:quiz_categorys',
      'root' => 'required|max:150',
      'description' => 'required|max:191',
      'pic_url' => 'max:2048|mimes:png,jpg,jpeg',
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
           Storage::put('public/images/quizcategory/' . $filename, File::get($file));
       }else{
          $filename='blank.jpg';
       }
       // dd($filename);
       if (request('lpk') != 'umum') {
         $lpk = request('lpk');
       } else {
         if (Auth::user()->lpk){
           $lpk = Auth::user()->lpk;
         } else {
           $lpk = null;
         }
       }
      QuizCategory::create(
        [
              'name' => request('name'),
              'lpk'=>$lpk,
              'root'=>request('root'),
              'description'=>request('description'),
              'pic_url'=>$filename
        ]
      );
      return response()->json(['success'=>'Data added successfully']);
      // return redirect(route('quizcategory.index'));
    }
  }
  public function edit($id)
  {
    $data = QuizCategory::find($id);
    return response()->json(['status' => 'ok','data'=>$data],200);
    // return view('quiz-category.edit', compact('data'));
  }

  public function update(Request $request, $id)
  {
    // dd($id);
    $data= QuizCategory::find($id);
    $rules = [
      'root_edit' => 'required|max:150',
      'lpk_edit' => 'required',
      'name_edit' => 'required|max:150',
      // 'name_edit' => 'required|max:150|unique:quiz_categorys,name,'.$data->id.',id',
      'description_edit' => 'required|max:191',
      'pic_url' => 'max:2048|mimes:png,jpg,jpeg',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()->all()]);
    }else{
      if(!empty($request->picture_edit)){
           $file = $request->file('picture_edit');
           $extension = strtolower($file->getClientOriginalExtension());
           $filename = $request->name_edit . '.' . $extension;
           Storage::delete('public/images/quizcategory/' . $data->pic_url);
           Storage::put('public/images/quizcategory/' . $filename, File::get($file));
      }else{
           $filename=$data->pic_url;
      }
      if (request('lpk_edit') != 'umum') {
         $lpk = request('lpk_edit');
      } else {
        if (Auth::user()->lpk){
          $lpk = Auth::user()->lpk;
        } else {
          $lpk = null;
        }
      }
      $data->name=$request->name_edit;
      if ($data->lpk != $lpk) {
        foreach ($data->quizType as $key => $value) {
          $value->lpk = $lpk;
          $value->save();
        }
        $data->lpk = $lpk;
      }
      $data->root=$request->root_edit;
      $data->description=$request->description_edit;
      $data->pic_url=$filename;
      $data->save();
      return response()->json(['success'=>'Data updated successfully']);
      // return redirect()->route('quizcategory.index');
    }
  }

  public function destroy($id)
  {
    $data = QuizCategory::find($id);
    Storage::delete('public/images/quizcategory/'.$data->pic_url);
    $data->delete();

    return redirect()->route('quizcategory.index');
  }

  public function picture($id)
  {
    $picture = QuizCategory::find($id);
    return Image::make(Storage::get('public/images/quizcategory/'.$picture->pic_url))->response();
  }

  public function getSelect(Request $request)
  {
    $param  = $request->get('term');
    $lpk = Auth::User()->lpk;
    $data = QuizCategory::select('id','name','root')->orWhere('name','like',"%$param%")
    ->when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('name');
    $list = [];
      foreach ($data as $key => $value) {
          $list[] = [
              'id'=>$value->id,
              'text'=>$value->root.' - '.$value->name
          ];
      }
      return response()->json($list);
  }

  public function getPreSelect(Request $request, $id)
  {
    $data = QuizCategory::select('id','name','root')->where('id',$id)->first();
    return response()->json($data);
  }


  /* START OF API */

  function api_menu(){
    $data = QuizCategory::orderBy('id')->groupBy('root')->select('root')->get();
    return response()->json([
      'status'=>'success',
      'result'=>$data
    ]);
  }

  function api_index(Request $request){
    if (!empty($request->root)) {
      $data = QuizCategory::where('root',$request->root)->orderBy('id')->get();
      return response()->json([
        'status'=>'success',
        'result'=>$data
      ]);
    } else {
      return response()->json([
        'status'=>'failed',
        'message'=>'Choose root before.'
      ]);
    }
  }

}
