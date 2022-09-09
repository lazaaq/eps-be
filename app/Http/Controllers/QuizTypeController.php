<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\QuizType;
use App\QuizCategory;
use App\Package;
use File;
use Validator;
use Cache;
use DB;
use Auth;

class QuizTypeController extends Controller
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
    
    // MASTER CLASS -> private, group
    for ($i=11; $i <= 17; $i++) { 
      QuizType::create(
        [
              'name' => 'Private',
              'quiz_category_id' => $i,
              'description'=>'Private',
              'pic_url'=>'blank.jpg'
        ]
      );
      QuizType::create(
        [
              'name' => 'Group',
              'quiz_category_id' => $i,
              'description'=>'Group',
              'pic_url'=>'blank.jpg'
        ]
      );
    }

    // KELAS BAHASA KOREA -> Non Interactive, Privat, Group
    // TOPIK -> Non Interactive, Privat, Group
    // EPS-TOPIK -> Non Interactive, Privat, Group, TRY OUT
    for ($i=18; $i <= 37; $i++) { 
      QuizType::create(
        [
              'name' => 'Non Interactive',
              'quiz_category_id' => $i,
              'description'=>'Non Interactive',
              'pic_url'=>'blank.jpg'
        ]
      );
      QuizType::create(
        [
              'name' => 'Private',
              'quiz_category_id' => $i,
              'description'=>'Private',
              'pic_url'=>'blank.jpg'
        ]
      );
      QuizType::create(
        [
              'name' => 'Group',
              'quiz_category_id' => $i,
              'description'=>'Group',
              'pic_url'=>'blank.jpg'
        ]
      );
    }
    for ($i=1; $i <= 5; $i++) {
      QuizType::create(
        [
              'name' => 'Paket '.$i,
              'quiz_category_id' => '38',
              'description'=>'Paket '.$i,
              'pic_url'=>'blank.jpg'
        ]
      );
    }
    DB::commit();
    return 'Success create data';
  }


  public function getData()
  {
    $lpk = Auth::User()->lpk;
    $data = QuizType::with('package')->when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('name');
    return datatables()->of($data)->addColumn('action', function($row){
      $btn = '<a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
      $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
      return $btn;
    })
    ->addColumn('quiz_category', function($row){
      return $row->quizCategory->root.' - '.$row->quizCategory->name;
    })
    ->addColumn('harga', function($row){
      $prices ='';
      foreach ($row->package as $key => $value) {
        $prices = $prices . '<label>'.'Rp '.number_format($value->price,0,".",".").'</label><br>';
      }
      return $prices;
    })
    ->addColumn('lpk_name', function($row){
      if (!empty($row->lpk)) {
        return $row->lpk()->first()->name;
      } else {
        return 'Umum';
      }
    })
    ->rawColumns(['action','harga'])
    ->make(true);
  }
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('quiz-type.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('quiz-type.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    // return $request;
    if (!empty(request('chk[]'))) {
      $rules = [
        'lpk' => 'required',
        'quiz_category' => 'required',
        'name' => 'required|max:150',
        // 'name' => 'required|max:150|unique:quiz_types,name',
        'description' => 'required|max:191',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
      ];      
    } else {
      $rules = [
        // 'lpk' => 'required',
        'quiz_category' => 'required',
        'name' => 'required|max:150',
        // 'name' => 'required|max:150|unique:quiz_types,name',
        'description' => 'required|max:191',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
        'price' => 'required|digits_between:1,10',
      ];
    }

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()->all()]);
    }else{
      if(!empty($request->picture)){
        $file = $request->file('picture');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid() . '.' . $extension;
        Storage::put('public/images/quiztype/' . $filename, File::get($file));
      }else{
        $filename='blank.jpg';
      }

      /*
      // LPK PILIH MANUAL
      if (request('lpk') != 'umum') {
        $lpk = request('lpk');
      } else {
        if (Auth::user()->lpk){
          $lpk = Auth::user()->lpk;
        } else {
          $lpk = null;
        }
      }*/
      // LPK BERDASAR KATEGORINYA
      $lpk = QuizCategory::find(request('quiz_category'))->lpk;

      DB::beginTransaction();
      $type = QuizType::create(
        [
              'name' => request('name'),
              'quiz_category_id' => request('quiz_category'),
              'description'=>request('description'),
              'lpk'=>$lpk,
              'pic_url'=>$filename
        ]
      );

      if (!empty(request('price'))) {
        $data = new Package;
        $data->quiz_type_id = $type->id;
        $data->price = $request->price;
        $data->save();
      }
      DB::commit();

      return response()->json(['success'=>'Data added successfully']);
    }


  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
      $data = QuizType::find($id);
      return response()->json(['status' => 'ok','data'=>$data],200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $data = QuizType::with('package')->find($id);
    return response()->json(['status' => 'ok','data'=>$data],200);
    // return view('quiz-type.edit', compact('data'));
  }

  public function picture($id)
  {
    $picture = Cache::remember('imgquiztype'.$id, 24*60, function() use ($id) {
      return QuizType::find($id)->pic_url;
    });

    return Image::make(Storage::get('public/images/quiztype/'.$picture))->response();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    // return $request;
    $data= QuizType::find($id);
    $rules = [
      // 'lpk_edit' => 'required',
      'quiz_category_edit' => 'required',
      'name_edit' => 'required|max:150',
      // 'name_edit' => 'required|max:150|unique:quiz_types,name,'.$id,
      'description_edit' => 'required|max:191',
      'picture_edit' => 'max:2048|mimes:png,jpg,jpeg',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()->all()]);
    }else{
      if(!empty($request->picture_edit)){
        $file = $request->file('picture_edit');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid() . '.' . $extension;
        Storage::put('public/images/quiztype/' . $filename, File::get($file));
      }else{
        $filename='blank.jpg';
      }
    }
    /*
    // LPK PILIH MANUAL
    if (request('lpk') != 'umum') {
      $lpk = request('lpk');
    } else {
      if (Auth::user()->lpk){
        $lpk = Auth::user()->lpk;
      } else {
        $lpk = null;
      }
    }*/
    // LPK BERDASAR KATEGORINYA
    $lpk = QuizCategory::find($request->quiz_category_edit)->lpk;

    $data->name=$request->name_edit;
    $data->quiz_category_id=$request->quiz_category_edit;
    $data->lpk=$lpk;
    $data->description=$request->description_edit;
    $data->pic_url=$filename;
    $data->save();

    if ($data->package[0]) {
      if (!empty(request('price_edit'))) {
        $package        = $data->package[0];
        $package->price = $request->price_edit;
        $package->save();
      } else {
        $package        = $data->package[0];
        $package->price = 0;
        $package->save();
      }
    } else {
      if (!empty(request('price_edit'))) {
        $package = new Package;
        $package->quiz_type_id = $data->id;
        $package->price = $request->price_edit;
        $package->save();
      }
    }

    Cache::forget('quiztype'.$id);
    Cache::forget('imgquiztype'.$id);

    return response()->json(['success'=>'Data updated successfully']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $data = QuizType::find($id);
    if (!empty($data->quiz)) {
      return response()->json([
        'status'=>'failed',
        'message'=>'Data is being used by another table.',
      ]);
    }
    else {
      Storage::delete('public/images/quiztype/'.$data->pic_url);
      $data->delete();
      Cache::forget('quiztype'.$id);
      Cache::forget('imgquiztype'.$id);
    }
  }

  /*START OF API*/

  function api_index($id){

    $data = Cache::remember('quiztype'.$id, 24*60, function() use ($id) {
      return QuizType::where('quiz_category_id', $id)->orderBy('id')->get();
    });
    // foreach ($data as $key => $value) {
    //   if($value->pic_url == 'blank.jpg'){
    //     $value->pic_url = asset('img/'.$value->pic_url.'');
    //   }else {
    //     $value->pic_url = route('quiztype.picture',$value->id);
    //   }
    // }
    return response()->json([
      'status'=>'success',
      'result'=>$data
    ]);
  }

}

?>
