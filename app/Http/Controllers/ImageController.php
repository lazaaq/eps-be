<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QuizType;
use App\QuizCategory;
use App\Quiz;
use App\Question;
use App\Answer;
use App\Banner;
use App\Instructor;
use Illuminate\Support\Facades\Storage;
use File;

class ImageController extends Controller
{
    public function pictureUser($pictureName)
    {
        $user = User::where('picture',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/user/'.$user->picture))->response();
    }

    public function pictureType($pictureName)
    {
        $type = QuizType::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/quiztype/'.$type->pic_url))->response();
    }

    public function pictureCategory($pictureName)
    {
        $category = QuizCategory::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/quizcategory/'.$category->pic_url))->response();
    }

    public function pictureQuiz($pictureName)
    {
        $quiz = Quiz::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/quiz/'.$quiz->pic_url))->response();
    }

    public function pictureQuestion($pictureName)
    {
        $question = Question::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/question/'.$question->pic_url))->response();
    }
    public function audioQuestion($pictureName)
    {
        $question = Question::where('audio_url',$pictureName)->first();
        $path = storage_path('public/audio/question/' . $question->audio_url);
 
        if (!File::exists($path)) {
        abort(404);
        }
 
        $file = \Storage::get($path);
        
 
       
        
 
         return $file;
        
    }

    public function pictureAnswer($pictureName)
    {
        $answer = Answer::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/answer/'.$answer->pic_url))->response();
    }

    public function pictureBanner($pictureName)
    {
        $banner = Banner::where('pic_url',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/banner/'.$banner->pic_url))->response();
    }

    public function pictureInstructor($pictureName)
    {
        $data = Instructor::where('picture',$pictureName)->first();
        return \Image::make(\Storage::get('public/images/instructor/'.$data->picture))->response();
    }
}
