<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Location;
use DB;
use Auth;
use App\Collager;
use App\Quiz;
use App\QuizType;
use Illuminate\Support\Carbon;
use App\QuizCollager;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::user()->lpk) {
        return redirect()->route('user-package.index');
      }
      $memberOnline     = DB::table('oauth_access_tokens')
                              ->groupBy('user_id')
                              ->where('revoked', 0)
                              ->selectRaw('user_id')
                              ->get()->count();
      $totalMember      = Collager::all()->count();
      $totalQuizType    = QuizType::all()->count();
      $totalGamePlayed  = QuizCollager::whereBetween('created_at',[Carbon::today(),Carbon::today()->addDay(1)])->count();
      $totalGamePlayedBefore  = QuizCollager::whereBetween('created_at',[Carbon::today()->addDay(-1),Carbon::today()])->count();
      $quiz = Quiz::all()->sortBy('quiz_type_id');
      $totalQuiz = $quiz->count();

      $score = QuizCollager::all();
      $collection = [];
      foreach ($quiz as $i => $quizs) {
        $collection[$i] = [
          'quiz_id'     => $quizs['id'],
          'title'  => $quizs['title'],
          'type'        => $quizs->quizType['name'],
          'category'    => $quizs->quizType->QuizCategory['name'],
          'leaderboard' => [],
        ];
        foreach ($score as $j => $scores) {
          if ($scores->quiz_id == $quizs['id']) {
            $leaderboard = $scores->leftJoin('collagers', 'quiz_collagers.collager_id', 'collagers.id')
                                  ->leftJoin('users', 'collagers.user_id', 'users.id')
                                  ->groupBy('quiz_collagers.collager_id','users.username', 'users.name','users.id','users.picture', 'quiz_collagers.quiz_id')
                                  ->where('quiz_collagers.quiz_id', $quizs['id'])
                                  ->selectRaw('users.id as user_id, quiz_collagers.collager_id, users.username, users.picture, max(quiz_collagers.total_score) as total_score, users.name, quiz_collagers.quiz_id')
                                  ->orderBy('total_score','DESC')
                                  // ->limit(5)
                                  ->get();
            $collection[$i]['leaderboard'] = $leaderboard;
          }
        }
      }
      // dd($collection);
      // return response()->json($collection);

      return view('index', compact ('quiz','memberOnline','totalMember','totalQuiz','totalQuizType','totalGamePlayed','totalGamePlayedBefore','collection'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
