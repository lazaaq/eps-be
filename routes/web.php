<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
  $exitCode = Artisan::call('config:clear');
  $exitCode = Artisan::call('cache:clear');
  $exitCode = Artisan::call('config:cache');
  return 'DONE'; //Return anything
});

Auth::routes();
// Auth::routes();

Route::get('/',function(){
    return view('landing-page');
});
Route::get('/foo', function () {
Artisan::call('storage:link');
});
Route:: get ('/coba', function () {
   return view('layout.layoutclean');
})->middleware('isAdmin')->middleware('verified');;
//admin
Route::group(['middleware' => 'auth'], function () {
    Route:: get ('/success-reset', function () {
        return view('auth.passwords.success');
    });
    Route::group(['middleware' => ['role:admin|Admin LPK'],'prefix' => '/admin'], function () {
        
        Route::group(['middleware' => ['role:admin']], function () {
            Route::resource('lecture', 'LectureController');
            Route::resource('banner', 'BannerController')->except('destroy');
            Route::resource('version', 'VersionAppController')->except('destroy');
            Route::resource('instructor', 'InstructorController')->except('destroy');
            Route::resource('package', 'PackageController')->except('destroy');
            Route::resource('schedule-detail', 'ScheduleDetailController')->except('destroy');
            Route::resource('noninteractive','NonInteractiveController')->except('destroy');
            Route::resource('lpk','LpkController')->except('destroy');
            Route::resource('payment-method','PaymentMethodController')->except('destroy');
            Route::resource('schedule', 'ScheduleController')->except('destroy');
            //uji kemampuan
            Route::resource('uji-kemampuan','UjiKemampuanController')->except('destroy');
            
            Route::get('user/delete/{id}', 'UserController@destroy')->name('user.destroy');
            Route::put('user/profile/{id}', 'UserController@updateProfil')->name('user.updateProfil');
            Route::put('user/profile/password/{id}', 'UserController@updatePassword')->name('user.updatePassword');
            
            Route::post('NonInteractive','NonInteractiveController@updateNonIn');
            Route::get('NonInteractive/{id}/edit','PackageController@packageNonIn');
            
            Route::get('instructor/delete/{id}', 'InstructorController@destroy')->name('instructor.destroy');
            Route::get('schedule-detail/delete/{id}', 'ScheduleDetailController@destroy')->name('schedule-detail.destroy');
            Route::get('banner/delete/{id}', 'BannerController@destroy')->name('banner.destroy');
            Route::post('banner/change-is-view/{id}', 'BannerController@changeIsView')->name('banner.changeIsView');
            Route::post('banner/change-is-viewWeb/{id}', 'BannerController@changeIsViewWeb')->name('banner.changeIsViewWeb');
            Route::get('version/delete/{id}', 'VersionAppController@destroy')->name('version.destroy');
            Route::get('package/delete/{id}', 'PackageController@destroy')->name('package.destroy');
            Route::get('uji-kemampuan/delete/{id}', 'UjiKemampuanController@destroy')->name('uji-kemampuan.destroy');
            Route::get('payment-method/delete/{id}', 'PaymentMethodController@destroy')->name('payment-method.destroy');
        });
        Route::resource('dashboard', 'DashboardController');
        Route::resource('history', 'HistoryController');
        Route::resource('user', 'UserController')->except('destroy');
        Route::resource('question', 'QuestionController');
        Route::resource('answersave', 'AnswerSaveController');
        Route::resource('collager', 'CollagerController');
        Route::resource('quiztype', 'QuizTypeController')->except('destroy');
        Route::resource('quizcategory', 'QuizCategoryController')->except('destroy');
        Route::resource('quizcollager', 'QuizCollagerController');
        Route::resource('quiz', 'QuizController')->except('destroy');
        //transaksi
        Route::resource('transaction','TransactionController');
        Route::resource('user-package', 'UserPackageController')->except('destroy');
        Route::get('user-package/{id}/add_package','UserPackageController@addPackage')->name('user-package.addPackage');

        Route::get('quiz/question/{id}','QuestionController@create')->name('quisz.question');
        Route::get('quiz/question/{id}/add','QuestionController@add')->name('quiz.questionAdd');
        Route::get('quiz/bulk/{id}/import','QuizController@import')->name('quiz.import');
        Route::post('quiz/bulk/{id}/import','QuizController@saveImport')->name('quiz.saveImport');
        Route::get('quiz/import/download', 'QuizController@downloadTemplate')->name('quiz.downloadTemplate');
        Route::get('quiz/export/{id}', 'QuizController@export')->name('quiz.export');

        Route::get('quiztype/delete/{id}', 'QuizTypeController@destroy')->name('quiztype.destroy');
        Route::get('quiz/delete/{id}', 'QuizController@destroy')->name('quiz.destroy');
        Route::get('question/delete/{id}', 'QuestionController@destroy')->name('question.destroy');
        Route::get('quizcategory/delete/{id}', 'QuizCategoryController@destroy')->name('quizcategory.destroy');
        Route::get('transaction/delete/{id}', 'TransactionController@destroy')->name('transaction.destroy');
    });

    Route::group(['middleware' => ['role:admin|Admin LPK'],'prefix' => '/table'], function () {
        Route::group(['middleware' => ['role:admin']], function () {
            Route::get('/data-banner', 'BannerController@getData');
            Route::get('/data-version', 'VersionAppController@getData');
            Route::get('/data-instructor', 'InstructorController@getData');
            Route::get('/data-package/{type}', 'PackageController@getData');
            Route::get('/data-noninteractive/{id}','NonInteractiveController@getData');
            Route::get('/data-uji-kemampuan', 'UjiKemampuanController@getData');
            Route::get('/data-schedule/{id}', 'ScheduleDetailController@getData');
            Route::get('/data-lpk', 'LpkController@getData');
            Route::get('/data-payment-method', 'PaymentMethodController@getData');
        });
        Route::get('/data-quiz-type', 'QuizTypeController@getData');
        Route::get('/data-quiz-category', 'QuizCategoryController@getData');
        Route::get('/data-quiz', 'QuizController@getData');
        Route::get('/data-user', 'UserController@getData');
        Route::get('/data-user-package', 'UserPackageController@getData');
        Route::get('/data-transaction', 'TransactionController@getData');
        Route::get('/data-transaction/change/{trans_id}', 'TransactionController@changeDataStatus');
    });

    Route::group(['middleware' => ['role:admin|Admin LPK'],'prefix' => '/select'], function () {
        Route::get('/data-quiz-category', 'QuizCategoryController@getSelect');
        Route::get('/data-quiz-category/{id}', 'QuizCategoryController@getPreSelect');
    });
});

Route::group(['middleware' => ['role:admin|Admin LPK'],'prefix' => '/table'], function () {
    Route::group(['middleware' => ['role:admin'],'prefix' => '/table'], function () {
        Route::get('/data-banner', 'BannerController@getData');
        Route::get('/data-version', 'VersionAppController@getData');
        Route::get('/data-lpk', 'LpkController@getData');
        Route::get('/data-payment-method', 'PaymentMethodController@getData');
    });
    Route::get('/data-quiz-type', 'QuizTypeController@getData');
    Route::get('/data-history', 'HistoryController@getData');
    Route::get('/data-history-user/{id}', 'HistoryController@getDataHistoryUser');
    Route::get('/data-history-chart/{id}', 'HistoryController@getDataChartUser');
    Route::get('/data-quiz-category', 'QuizCategoryController@getData');
    Route::get('/data-quiz', 'QuizController@getData');
    Route::get('/data-user', 'UserController@getData');
    Route::get('/data-user-package', 'UserPackageController@getData');
});

Route::group(['middleware' => ['role:admin|Admin LPK'],'prefix' => '/search'], function () {
    Route::get('/quiz/{id}', 'QuizController@search')->name('search.action');
});

Route::group(['prefix' => '/storage'], function () {
    Route::get('user/{id}', 'UserController@picture')->name('user.picture');
    Route::get('quiz_type/{id}', 'QuizTypeController@picture')->name('quiztype.picture');
    Route::get('quiz_category/{id}', 'QuizCategoryController@picture')->name('quizcategory.picture');
    Route::get('quiz/{id}', 'QuizController@picture')->name('quiz.picture');
    Route::get('question/{id}', 'QuestionController@picture')->name('question.picture');
    Route::get('answer/{id}', 'AnswerController@picture')->name('answer.picture');
    Route::get('banner/{id}', 'BannerController@picture')->name('banner.picture');
    Route::get('instructor/{id}', 'InstructorController@picture')->name('instructor.picture');

    Route::get('quiz_type/{pictureName}', 'ImageController@pictureType');
    Route::get('quiz_category/{pictureName}', 'ImageController@pictureCategory');
    Route::get('quiz/{pictureName}', 'ImageController@pictureQuiz');
    Route::get('question/{pictureName}', 'ImageController@pictureQuestion');
    Route::get('answer/{pictureName}', 'ImageController@pictureAnswer');
    Route::get('banner/{pictureName}', 'ImageController@pictureBanner');
    Route::get('instructor/{pictureName}', 'ImageController@pictureInstructor');
});
