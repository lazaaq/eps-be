<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use DataTables;
use App\QuizType;
use App\Quiz;
use App\Answer;
use App\Question;
use File;
use DB;

class QuestionController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    $quiz = Quiz::find($id);
    return view('question.create', compact('quiz'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $this->validate($request,
    [
      'question.*' => 'required_without:audio.*',
      'picture.*' => 'mimes:png,jpg,jpeg|max:2048',
      'audio.*' => 'mimes:mp3|required_without:question.*',
      'choice.*.*' => 'required_without:picture_choice.*.*',
      'picture_choice.*.*' => 'mimes:png,jpg,jpeg|max:2048|required_without:choice.*.*',
    ],
    [
      'question.*.required_without' => 'The question field is required when audio field is not present.',
      'audio.*.required_without' => 'The audio field is required when question field is not present.',
      'picture.*.mimes' => 'The file must be a file of type: png, jpg, jpeg.',
      'audio.*.mimes' => 'The file must be a file of type: MP3.',
      'choice.*.*.required_without' => 'The choice field is required when file field is not present.',
      'picture_choice.*.*.required_without' => 'The file field is required when choice field is not present.',
      'picture_choice.*.*.mimes' => 'The file must be a file of type: png, jpg, jpeg.',

    ]);
    $quiz = Quiz::find($request->quiz_id);
    $questionCount = Question::where('quiz_id', $quiz->id)->get()->count();
    DB::beginTransaction();
    /*fitur add question*/
    if ($quiz->sum_question == $questionCount) {
      $quiz->sum_question+= @count($request->question);
      $quiz->save();
    }
    $quiz->sum_question = $quiz->sum_question - @count($request->question);
    /*end of fitur add question*/
    $question = [];

    for ($i=0; $i < @count($request->question); $i++) {
        // uploade image
        if (!empty($request->picture[$i])) {
            $file[$i] = $request->file('picture.'.$i);
            $extension[$i] = strtolower($file[$i]->getClientOriginalExtension());
            $filenamePicture[$i] = uniqid() . '.' . $extension[$i];
            \Storage::put('public/images/question/' . $filenamePicture[$i], \File::get($file[$i]));
        } else {
          $filenamePicture[$i] = '';
        }

        // uploade audio
        if (!empty($request->audio[$i])) {
            $file[$i] = $request->file('audio.'.$i);
            $extension[$i] = strtolower($file[$i]->getClientOriginalExtension());
            $filenameAudio[$i] = uniqid() . '.' . $extension[$i];
            \Storage::put('public/audio/question/' . $filenameAudio[$i], \File::get($file[$i]));
        } else {
          $filenameAudio[$i] = NULL;
        }
        $question[$i] = [
            'quiz_id'       => $request->quiz_id,
            'question'      => $request->question[$i]?:'',
            'pic_url'       => $filenamePicture[$i],
            'audio_url'     => $filenameAudio[$i]
        ];

    }

    $answers = [];
    $option = ['A', 'B', 'C', 'D', 'E'];
    for ($i=0; $i < @count($request->choice); $i++) {
        for ($j=0; $j < @count($request->choice[$i]); $j++) {
            $answers[$i][$j] = [
                 'option'        => $option[$j],
                 'content'       => $request->choice[$i][$j],
                 'isTrue'        => $request->true_answer[$i] == $j+1 ? 1 : 0
            ];
        }

        for ($j=0; $j < @count($request->picture_choice[$i]); $j++) {
          if (!empty($request->picture_choice[$i][$j])) {
              $fileChoice[$i][$j] = $request->file('picture_choice.'.$i.'.'.$j);
              $extensionChoice[$i][$j] = strtolower($fileChoice[$i][$j]->getClientOriginalExtension());
              $filenameChoice[$i][$j] = uniqid() . '.' . $extensionChoice[$i][$j];
              \Storage::put('public/images/option/' . $filenameChoice[$i][$j], \File::get($fileChoice[$i][$j]));
          } else {
            $filenameChoice[$i][$j] = '';
          }
           $answers[$i][$j] = array_slice($answers[$i][$j], 0, 2, true) + array("pic_url" => $filenameChoice[$i][$j]) + array_slice($answers[$i][$j], 2, count($answers[$i][$j]) - 1, true);
        }
    }
    foreach ($question as $key => $q) {
      Question::create($q)->answer()->createMany($answers[$key]);
    }
    DB::commit();
    if ($quiz->sum_question == $questionCount) {
      return redirect()->route('quiz.show',$quiz->id);
    }
      return redirect()->route('quiz.index');
  }

  public function add(Request $request, $id)
  {
      $quiz = Quiz::find($id);
      $total = $request->total_add;
      return view('question.create-add', compact('quiz','total'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $data = Question::find($id);
    $quiz = Quiz::find($data->quiz_id);
    $option = ['First','Second','Third','Fourth','Fifth'];
    $option_value = ['A','B','C','D','E'];
    // dd($data);
    return view('question.edit', compact('data','quiz','option','option_value'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
public function update(Request $request, $id)
  {
    $this->validate($request,
    [
      'question.*' => 'required_without:audio.*',
      'picture.*' => 'mimes:png,jpg,jpeg|max:2048',
      'audio.*' => 'mimes:mp3|required_without:question.*',
      'picture_choice.*' => 'mimes:png,jpg,jpeg|max:2048',
    ],
    [
      'question.*.required_without' => 'The question field is required when audio field is not present.',
      'audio.*.required_without' => 'The audio field is required when question field is not present.',
      'picture.*.mimes' => 'The file must be a file of type: png, jpg, jpeg.',
      'audio.*.mimes' => 'The file must be a file of type: MP3.',
      'picture_choice.*.mimes' => 'The file must be a file of type: png, jpg, jpeg.',

    ]);

    $data = Question::find($id);
    $quiz = Quiz::find($data->quiz_id);
    $option = ['A', 'B', 'C', 'D', 'E'];

    DB::beginTransaction();
    if (!empty($request->picture)) {
        $file = $request->file('picture');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid() . '.' . $extension;
        $img = Image::make($file)->resize(800, 500);
        Storage::delete('public/images/question/'.$data->pic_url);
        \Storage::put('public/images/question/' . $filename, $img->encode());
        $data->pic_url=$filename;
    }
    if (!empty($request->audio)) {
        $file = $request->file('audio');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid() . '.' . $extension;
        Storage::delete('public/audio/question/'.$data->audio_url);
        \Storage::put('public/audio/question/' . $filename, \File::get($file));
        $data->audio_url=$filename;
    }
    $data->question=$request->question?:'';
    $data->save();
    if (!$data) {
      DB::rollback();
      return 'failed DB transaction';
    }
    for ($i=0; $i<=$request->jumlah; $i++) {
      if ($data->answer->count() > $request->jumlah+1) {
        #kurang
        if ($i < $request->jumlah) {
          $data->answer->get($i)->content  = $request->choice[$i];
          $data->answer->get($i)->save();
        } else {
          for ($j=$request->jumlah+1; $j <5 ; $j++) {
            if ($data->answer->get($j) != null) {
              $option = Answer::find($data->answer->get($j)->id);
              Storage::delete('public/images/option/'.$data->answer->get($j)->pic_url);
              $option->delete();
            }

          }
        }
      } elseif ($data->answer->count() < $request->jumlah+1) {
        #tambah
        if ($data->answer->get($i) != null) {
          $data->answer->get($i)->content  = $request->choice[$i];
          $data->answer->get($i)->save();
        } else {
          $answers = [
            'option'        => $option[$i],
            'content'       => $request->choice[$i],
            'isTrue'        => 0
          ];
          $data->answer()->create($answers);
        }
      } else {
          $data->answer->get($i)->content  = $request->choice[$i];
          $data->answer->get($i)->save();
      }
    }

    DB::commit();
    for ($i=0; $i<=$request->jumlah; $i++) {
      if (!empty($request->picture_choice[$i])) {
        $fileChoice[$i] = $request->file('picture_choice.'.$i);
        $extensionChoice[$i] = strtolower($fileChoice[$i]->getClientOriginalExtension());
        $filenameChoice[$i] = uniqid() . '.' . $extensionChoice[$i];
        $imgChoice[$i] = Image::make($fileChoice[$i])->resize(300, 200);
        if ($data->answer->get($i) != null) {
          Storage::delete('public/images/option/'.$data->answer->get($i)->pic_url);
        }
        Storage::put('public/images/option/' . $filenameChoice[$i], $imgChoice[$i]->encode());
        $data->answer->get($i)->pic_url = $filenameChoice[$i];
        $data->answer->get($i)->save();
      }
    }
    return redirect()->route('quiz.show',$data->quiz_id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    DB::beginTransaction();
    $data = Question::find($id);

    $answer = Answer::where('question_id', $id)->get();
    foreach ($answer as $key => $value) {
      Storage::delete('public/images/answer/'.$value->pic_url);
      $value->delete();
    }
    if (!$answer) {
      DB::rollback();
      return 'failed DB transaction';
    }

    Storage::delete('public/images/question/'.$data->pic_url);
    Storage::delete('public/audio/question/'.$data->audio_url);
    $data->delete();
    if (!$data) {
      DB::rollback();
      return 'failed DB transaction';
    }

    $quiz = Quiz::where('id', $data->quiz_id)->first();
    $quiz->sum_question = $quiz->sum_question - 1;
    $quiz->save();
    if (!$quiz) {
      DB::rollback();
      return 'failed DB transaction';
    }
    DB::commit();
    return redirect()->route('quiz.show',$quiz->id);
  }

  public function picture($id)
  {
    $data = Question::find($id);
    return \Image::make(\Storage::get('public/images/question/'.$data->pic_url))->response();
  }
  /*START OF API*/
  public function api_index($id)
  {
      $quiz = Quiz::where('id', $id)->first();
      if(!empty($quiz)){
          $question = Question::where('quiz_id', $quiz->id)->with('answer')->get();
        } else {
        return response()->json([
            'status' => 'failed',
            'message'   => 'Quiz not found'
        ]);
      }

    // KHUSUS UNTUK TES KEMAMPUAN
      if ($quiz->quizType->quizCategory->id == 1) {
            $collection = [];
            foreach ($question as $i => $item) {
                $opt = $item->answer()->orderBy('option', 'asc')->get();
                $type = 'option';
                $collection2 = [];
                foreach ($opt as $key => $value) {
                    $collection2[$key] = [
                        'id' => $value['id'],
                        'question_id' => $value['question_id'],
                        'option' => $value['option'],
                        'content' => $value['content'],
                        'pic_url' => $value['pic_url'],
                        'isTrue' => $value['isTrue'],
                        'choosen' => 0,
                    ];
                }
                shuffle($collection2);
                $collection[$i] = [
                    'id' => $item['id'],
                    'question' => $item['question'],
                    'pic_question' => $item['pic_url'],
                    'duration' => $item['time'],
                    'trueAnswer' => $item->answer()->orderBy('option', 'asc')->get()->where('isTrue', 1)->first()->option,
                    'trueAnswerContent' => $item->answer()->orderBy('option', 'asc')->get()->where('isTrue', 1)->first()->content,
                    'trueAnswerPic' => $item->answer()->orderBy('option', 'asc')->get()->where('isTrue', 1)->first()->pic_url,
                    'userAnswer' => '**',
                    'userAnswerContent' => '**',
                    'option' => $collection2,
                ];
            }

            $data = Arr::random($collection, $quiz->tot_visible);
            shuffle($data);
            return response()->json([
                'status'        => 'success',
                'quiz'          => $quiz,
                'question'      => $data
            ]);
      }


      // foreach ($quiz as $key => $value) {
      //   if(!empty($value->pic_url)){
      //     $value->pic_url = route('question.picture',$value->id);
      //   }
      // }
      $option  = [];
      foreach ($question as $key => $item) {
          $option[$key] = $item->answer()->orderBy('option', 'asc')->get();
      }
      // foreach ($option[0] as $key => $value) {
      //   if(!empty($value->pic_url)){
      //     $value->pic_url = route('answer.picture',$value->id);
      //   }
      // }
      $collection = [];
      foreach ($question as $i => $item) {
        $collection[$i] = [
          'id' => $item['id'],
          'question' => $item['question'],
          'pic_question' => $item['pic_url'],
          'a' => $option[$i]->get(0)->content,
          'pic_a' => $option[$i]->get(0)->pic_url,
          'b' => $option[$i]->get(1)->content,
          'pic_b' => $option[$i]->get(1)->pic_url,
          'c' => $option[$i]->get(2)->content,
          'pic_c' => $option[$i]->get(2)->pic_url,
          'd' => $option[$i]->get(3)->content,
          'pic_d' => $option[$i]->get(3)->pic_url,
          'e' => $option[$i]->get(4)->content,
          'pic_e' => $option[$i]->get(4)->pic_url,
          'isTrueOpt' => $option[$i]->where('isTrue', 1)->first()->option,
          'trueAnswer' => $option[$i]->where('isTrue', 1)->first()->content,
          'trueAnswerPic' => $option[$i]->where('isTrue', 1)->first()->pic_url,
        ];
      }
      $data = Arr::random($collection, $quiz->tot_visible);
      return response()->json([
          'status' => 'success',
          'result'   => $data
      ]);
  }
}

?>
