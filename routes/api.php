<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::group(['middleware' => ['api']], function () {
//   Route::put('quiztype/{id}', 'QuizTypeController@update')->name('quiztype.update');
// });

/*START di comment karena udah di rend, tapi jangan dihapus*/
// Route::group(['middleware' => ['api'],'prefix' => '/admin'], function () {
//   Route::get('/data-quiz-type','QuizTypeController@createDataDefault');
//   Route::get('/data-quiz-category','QuizCategoryController@createDataDefault');
// });
/*END di comment karena udah di rend, tapi jangan dihapus*/

Route::group(['middleware' => ['api'],'prefix' => '/collager'], function () {
  Route::post('/register', 'UserController@api_collagerRegister');
  Route::post('/login','UserController@api_collagerLogin');
  Route::post('/forgot-password', 'Auth\ForgotPasswordAPIController');
  Route::get('/version', 'VersionAppController@api_index');
  Route::get('/component','ComponentController@index');
});
Route::group(['middleware' => ['auth:api'],'prefix' => '/collager'], function () {
  Route::get('/logout', 'UserController@api_logout');
  Route::get('/detail', 'UserController@api_index');
  Route::put('/update', 'UserController@api_update');
  Route::put('/update-password', 'UserController@api_updatePassword');
  Route::put('/upload-avatar', 'UserController@api_uploadAvatar');

  Route::get('/menu','QuizCategoryController@api_menu');
  Route::get('/category','QuizCategoryController@api_index');
  Route::get('/quiztype/{category_id}','QuizTypeController@api_index');
  Route::get('/quiz/{quiztype_id}','QuizController@api_index');
  Route::get('/question/{quiz_id}','QuestionController@api_index');
  Route::post('/quiz/store','QuizCollagerController@api_store');

  Route::get('/history','QuizCollagerController@api_history');
  Route::get('/leaderboard','QuizCollagerController@api_leaderboard');
  Route::get('/leaderboard-podium/{id_quiz}','QuizCollagerController@api_leaderboardQuizPodium');
  Route::get('/leaderboard-not-podium/{id_quiz}','QuizCollagerController@api_leaderboardQuizNotPodium');

  Route::get('/package/{type_id}','PackageController@api_index');
  Route::get('/schedule/{package_id}','ScheduleDetailController@api_index');
  Route::get('/non-interactive/{package_id}','NonInteractiveController@api_index');

  Route::get('/package/cek-status/{type_id}','TransactionController@api_cekStatus');
  Route::post('/transaction/store','TransactionController@api_store');
  Route::get('/transaction/list','TransactionController@api_list');
  Route::get('/transaction/detail/{id}','TransactionController@api_show');
  Route::get('/transaction/failed/{id}','TransactionController@api_statusFailed');
  Route::post('/transaction/evidence/{id}','TransactionController@api_uploadBuktiTransfer');

  Route::get('/banner','BannerController@api_index');

  //uji kemampuan
  Route::post('uji-kemampuan/store','UjiKemampuanController@storeUjiKemampuan');

  // upload foto
  Route::post('/upload-foto', 'UploadFotoController@uploadFoto');
});

Route::group(['middleware' => ['api'],'prefix' => '/storage'], function () {
  Route::get('user/{pictureName}', 'ImageController@pictureUser');
  Route::get('quiz_type/{pictureName}', 'ImageController@pictureType');
  Route::get('quiz_category/{pictureName}', 'ImageController@pictureCategory');
  Route::get('quiz/{pictureName}', 'ImageController@pictureQuiz');
  Route::get('question/{pictureName}', 'ImageController@pictureQuestion');
  Route::get('answer/{pictureName}', 'ImageController@pictureAnswer');
  Route::get('banner/{pictureName}', 'ImageController@pictureBanner');
  Route::get('audio/question/{pictureName}', 'ImageController@audioQuestion');
 
});

