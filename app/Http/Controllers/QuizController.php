<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use File;
use App\QuizCategory;
use App\QuizType;
use App\Quiz;
use App\Question;
use DataTables;
use DB;
use Validator;
use Excel;
use App\Imports\QuestionImport;
use Redirect;
use Auth;

class QuizController extends Controller
{

  public function getData()
  {
    $lpk = Auth::User()->lpk;
    $data = Quiz::when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('title');
    return datatables()->of($data)
    ->addColumn('action', function($row){
      $btn = '<a href="'.route('quiz.show',$row->id).'" title="View" class="btn border-success btn-xs text-success-600 btn-flat btn-icon"><i class="glyphicon glyphicon-eye-open"></i></a>';
      $btn = $btn.'  <a id="btn-edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
      // $btn = $btn.'  <a href="'.route('quiz.edit',$row->id).'" title="Edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
      $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
      // $btn = $btn.'  <a href="'.route('quiz.destroy',$row->id).'" title="Delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></a>';
      return $btn;
    })
    ->rawColumns(['action'])
    ->addColumn('quiz_category', function($row){
      return $row->quizType->quizCategory->name;
    })
    ->addColumn('quiz_type', function($row){
      return $row->quizType->name;
    })
    ->addColumn('lpk_name', function($row){
      if (!empty($row->lpk)) {
        return $row->lpk()->first()->name;
      } else {
        return 'Umum';
      }
    })
    ->make(true);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $lpk = Auth::User()->lpk;
    $quizcategory = QuizCategory::all()->sortBy('name');
    $quiztype = QuizType::when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('name');
    return view('quiz.index', compact('quiztype','quizcategory'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $lpk = Auth::User()->lpk;
    $quiztype = QuizType::when($lpk, function ($query, $lpk) {
      return $query->where('lpk', $lpk);
    })->get()->sortBy('name');
    return view('quiz.create', compact('quiztype'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $rules = [
        'lpk' => 'required',
        'quiz_type' => 'required',
        'title' => 'required|max:150',
        // 'title' => 'required|max:150|unique:quizs',
        'description' => 'required|max:191',
        'time' => 'required',
        'total_visible_question' => 'required',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->all()]);
      }else{
        if(!empty($request->picture)){
             $file = $request->file('picture');
             $extension = strtolower($file->getClientOriginalExtension());
             $filename = uniqid() . '.' . $extension;
             Storage::put('public/images/quiz/' . $filename, File::get($file));
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
        $data = Quiz::create(
          [
                'quiz_type_id' => request('quiz_type'),
                'title' => request('title'),
                'description'=>request('description'),
                'timer_quiz'=>request('time'),
                'tot_visible'=>request('total_visible_question'),
                'lpk'=>$lpk,
                'pic_url'=>$filename
          ]
        );
        return response()->json(['success'=>'Data added successfully','data'=>$data]);
        // return redirect('admin/quiz/question/'.$data->id);
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
    $quiz = Quiz::where('id', $id)->first();
    $question = Question::where('quiz_id', $quiz->id)->orderBy('id')->paginate(10);
    $number = $question->firstItem();
    // $question = DB::table('questions')->where('quiz_id', $quiz->id)->paginate(3);
    return view('quiz.view', compact('quiz','question','number'));
  }

  public function search(Request $request, $id)
  {
    if($request->ajax())
     {
      $quiz = Quiz::where('id', $id)->first();
      $query = $request->get('query');
      $query = str_replace(" ", "%", $query);
      $question = Question::where('quiz_id', $quiz->id)->where('question', 'like', '%'.$query.'%')->orderBy('id')->paginate(10);
      $number = $question->firstItem();
      return view('quiz.view_data', compact('quiz','question','number'))->render();
     }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $data = Quiz::where('id', $id)->with('QuizType')->first();
    return response()->json(['status' => 'ok','data'=>$data],200);
    // return view('quiz.edit', compact('data','quiztype'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $data= Quiz::find($id);
    $rules = [
      'lpk_edit' => 'required',
      'quiz_type_edit' => 'required',
      'title_edit' => 'required|max:150',
      // 'title_edit' => 'required|max:150|unique:quizs,title,'.$data->id.',id',
      'description_edit' => 'required|max:191',
      'total_visible_question_edit' => 'required',
      'time' => 'required',
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
           Storage::delete('public/images/quiz/' . $data->pic_url);
           Storage::put('public/images/quiz/' . $filename, File::get($file));
      }else{
           $filename=$data->pic_url;
      }
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
    $data->quiz_type_id=$request->quiz_type_edit;
    $data->title=$request->title_edit;
    $data->lpk=$lpk;
    $data->description=$request->description_edit;
    $data->tot_visible=$request->total_visible_question_edit;
    $data->timer_quiz=$request->time;
    $data->pic_url=$filename;
    $data->save();
    return response()->json(['success'=>'Data updated successfully']);
    // return redirect()->route('quiz.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $data = Quiz::find($id);
    Storage::delete('public/images/quiz/'.$data->pic_url);
    $data->delete();

    return redirect()->route('quiz.index');
  }

  public function picture($id)
  {
    $picture = Quiz::find($id);
    return Image::make(Storage::get('public/images/quiz/'.$picture->pic_url))->response();
  }

  public function import($id)
  {
    $data = Quiz::find($id);
    return view('quiz.import',compact('data'));
  }

  public function saveImport(Request $request, $id)
  {
    $this->validate(request(),
      [
        'excel' => 'required|mimes:xlsx',
      ]
    );
    $data = Quiz::find($id);
    DB::beginTransaction();

    $file = $request->file('excel');
    $import = Excel::load($file)->get();
    if (!$import) {
      DB::rollback();
      return redirect()->route('quiz.show',$id)->with('dbTransactionError','Something wrong!');
    }
    $import_data_filter = array_filter($import->toArray());

    foreach ($import_data_filter as $key => $value) {
      if (($check = array_search('Diantara berikut ini yang bukan merupakan anggota girlband Blackpink adalah?', $value)) !== false) {
        unset($import_data_filter[$key]);
      }
      else {
        if (implode($value) == null) {
          unset($import_data_filter[$key]);
        }
      }
    }

    $import_data_filter = array_values($import_data_filter);

    $totalQuestion = count($import_data_filter);
    $messages_error = [];
    foreach ($import_data_filter as $key => $value) {
      $messages_error[$key.'.question.required'] = "Question field number ".($key+1)." is empty.";
      $messages_error[$key.'.question.distinct'] = "Question field number ".($key+1)." has duplicate value.";
      $messages_error[$key.'.question.unique'] = "Question field number ".($key+1)." has already been taken.";
      $messages_error[$key.'.option_a.required'] = "Option A field number ".($key+1)." is empty.";
      $messages_error[$key.'.option_b.required'] = "Option B field number ".($key+1)." is empty.";
      $messages_error[$key.'.option_c.required'] = "Option C field number ".($key+1)." is empty.";
      $messages_error[$key.'.option_d.required'] = "Option D field number ".($key+1)." is empty.";
      $messages_error[$key.'.option_e.required'] = "Option E field number ".($key+1)." is empty.";
    }

    $validator = Validator::make($import_data_filter,[
      '*.question' => 'required|distinct|unique:questions,question',
      '*.option_a' => 'required',
      '*.option_b' => 'required',
      '*.option_c' => 'required',
      '*.option_d' => 'required',
      '*.option_e' => 'required'
    ],$messages_error);

    $get_error = [];
    foreach ($validator->errors()->messages() as $key => $value) {
      $get_error[] = $key;
    }
    $error = array_unique($get_error);
    $question = [];
    $answers = [];
    $option = ['A', 'B', 'C', 'D', 'E'];

    $count_error = 0;
    foreach ($import_data_filter as $key => $row) {
      if (in_array($key, $error)) {
        continue;
        $count_error++;
      } else {
        $question[$key] = [
            'quiz_id'       => $id,
            'question'      => $row['question'],
        ];

        $content = [$row['option_a'],$row['option_b'],$row['option_c'],$row['option_d'],$row['option_e']];

        for ($i=0; $i < 5 ; $i++) {
            $answers[$key][$i] = [
                'option'  => $option[$i],
                'content' => $content[$i],
                'isTrue'  => $row['true_answer'] == $option[$i] ? 1 : 0,
            ];
        }
      }
    }
    $totalQuestionSuccess = count($question);

    foreach ($question as $key => $q) {
        Question::create($q)->answer()->createMany($answers[$key]);
    }

    $data->sum_question = $data->sum_question + $totalQuestionSuccess;
    $data->save();
    DB::commit();
    return redirect()->route('quiz.show',$id)->withErrors($validator)->with('totalQuestion',$totalQuestion)->with('totalQuestionSuccess',$totalQuestionSuccess);
  }

  public function downloadTemplate()
  {
    $path = 'template/Template Import Quiz.xlsx';
    return response()->download($path);
  }

  public function export($id)
  {
      $quiz = Quiz::where('id', $id)->first();
      $question = Question::where('quiz_id', $quiz->id)->get();
      $option  = [];
      foreach ($question as $key => $item) {
          $option[$key] = $item->answer()->orderBy('option', 'asc')->get();
      }
      $collection = [];
      foreach ($question as $i => $item) {
        $collection[$i] = [
          'id' => $item['id'],
          'question' => $item['question'],
          'a' => $option[$i]->get(0)->content,
          'b' => $option[$i]->get(1)->content,
          'c' => $option[$i]->get(2)->content,
          'd' => $option[$i]->get(3)->content,
          'e' => $option[$i]->get(4)->content,
          'isTrueOpt' => $option[$i]->where('isTrue', 1)->first()->option,
        ];
      }
      return Excel::create('Export Quiz '.$quiz->title, function($excel) use ($collection)
      {
          $excel->sheet('Sheet1', function($sheet) use ($collection)
          {
              $sheet->freezeFirstRow();
              $sheet->setStyle(array(
                  'font' => array(
                      'name'      =>  'Calibri',
                      'size'      =>  12,
                  )
              ));
              $sheet->setAutoSize(array(
                  'A', 'C', 'D', 'E', 'F', 'G', 'H'
              ));
              $sheet->setWidth(array(
                  'B'     =>  74,
              ));

              $sheet->cell('A1:H1', function($cell)
              {
                  $cell->setBackground('#ede185');
                  $cell->setFontWeight('bold');
              });
              $sheet->cell('A1', function($cell)
              {
                  $cell->setValue('NO');
              });

              $sheet->cell('B1', function($cell)
              {
                  $cell->setValue('QUESTION');
              });

              $sheet->cell('C1', function($cell)
              {
                  $cell->setValue('OPTION A');
              });
              $sheet->cell('D1', function($cell)
              {
                  $cell->setValue('OPTION B');
              });
              $sheet->cell('E1', function($cell)
              {
                  $cell->setValue('OPTION C');
              });
              $sheet->cell('F1', function($cell)
              {
                  $cell->setValue('OPTION D');
              });
              $sheet->cell('G1', function($cell)
              {
                  $cell->setValue('OPTION E');
              });
              $sheet->cell('H1', function($cell)
              {
                  $cell->setValue('TRUE ANSWER');
              });

              if (!empty($collection))
              {
                  foreach ($collection as $key => $value)
                  {
                      $i= $key+2;
                      $sheet->cell('A'.$i, $key+1);
                      $sheet->cell('B'.$i, $value['question']);
                      $sheet->cell('C'.$i, $value['a']);
                      $sheet->cell('D'.$i, $value['b']);
                      $sheet->cell('E'.$i, $value['c']);
                      $sheet->cell('F'.$i, $value['d']);
                      $sheet->cell('G'.$i, $value['e']);
                      $sheet->cell('H'.$i, $value['isTrueOpt']);
                  }
              }
          });
      })->download('xlsx');
  }

  /*START OF API*/
  public function api_index($id){
    $data = Quiz::where('quiz_type_id', $id)
                  ->leftJoin('quiz_types', 'quizs.quiz_type_id', '=', 'quiz_types.id')
                  ->orderBy('quizs.id')
                  ->select('quizs.id',// 'quiz_types.name as type',
                    'quizs.sum_question','quizs.pic_url')
                  // ->select('quizs.id', 'quiz_types.name as type', 'quizs.title', 'quizs.description', 'quizs.sum_question','quizs.pic_url')
                  ->get();
    if (empty($data[0])) {
      return response()->json([
        'status'=>'failed',
        'message'=>'Not found quiz data.'
      ]);
    }
    // foreach ($data as $key => $value) {
    //   if($value->pic_url == 'blank.jpg'){
    //     $value->pic_url = asset('img/'.$value->pic_url.'');
    //   }else {
    //     $value->pic_url = route('quiz.picture',$value->id);
    //   }
    // }
    return response()->json([
      'status'=>'success',
      'result'=>$data
    ]);
  }

}

?>
