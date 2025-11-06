<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormdataController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\System_settingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Taxonomies_settingController;
use App\Http\Controllers\Teacher_settingController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::post('/form/store' ,[FormdataController::class ,'store'])->name('form.submit');
// Route::post('/form' ,[FormdataController::class ,'index']);
// Route::get('/form/{id}/edit',[FormdataController::class ,'edit'])->name('form.edit');
// Route::post('/form/delete/{id}',[FormdataController::class ,'delete'])->name('form.delete');


Route::resource('teacher', TeacherController::class);
Route::resource('platform', PlatformController::class);
Route::resource('report', ReportController::class);
Route::resource('setting', SettingController::class);

Route::get('teacher_setting/create', [SettingController::class , 'create'])->name('teacher_setting.create');
Route::get('taxonomies_setting/create', [SettingController::class , 'create'])->name('taxonomies_setting.create');
Route::get('system_setting/create', [SettingController::class , 'create'])->name('system_setting.create');



// Developer personal comments: this is the routes for setting updates.
Route::post('security/{id}/update', [System_settingController::class,'security_update'])->name('security_setting.update');
Route::post('currency/update', [System_settingController::class,'currency_update']);
Route::post('/notification-settings/update', [System_settingController::class, 'notification_settings_update'])->name('notification_settings.update');


//Developer personal comments: This is the routes for taxonomies educational system.
Route::post('taxonomies/educational_systems/store' ,[Taxonomies_settingController::class , 'store_educational_systems'])->name('taxonomies_educational_systems.store');
Route::get('taxonomies/educational_systems/index' ,[Taxonomies_settingController::class , 'index_educational_systems'])->name('taxonomies_educational_systems.index');
Route::delete('taxonomies/educational_systems/delete/{id}' ,[Taxonomies_settingController::class , 'delete_educational_systems'])->name('taxonomies_educational_systems.delete');



//Developer personal comments: This is the routes for taxonomies subject.
Route::post('taxonomies/subjects/store' ,[Taxonomies_settingController::class , 'store_subjects'])->name('taxonomies_subjects.store');
Route::get('taxonomies/subjects/index' ,[Taxonomies_settingController::class , 'index_subjects'])->name('taxonomies_subjects.index');
Route::delete('taxonomies/subjects/delete/{id}' ,[Taxonomies_settingController::class , 'delete_subjects'])->name('taxonomies_subjects.delete');

//Developer personal comments: This is the routes for taxonomies examination board.
Route::post('taxonomies/examination_board/store' ,[Taxonomies_settingController::class , 'store_examination_board'])->name('taxonomies_examination_board.store');
Route::get('taxonomies/examination_board/index' ,[Taxonomies_settingController::class , 'index_examination_board'])->name('taxonomies_examination_board.index');
Route::delete('taxonomies/examination_board/delete/{id}' ,[Taxonomies_settingController::class , 'delete_examination_board'])->name('taxonomies_examination_board.delete');

//Developer personal comments: This is the routes for taxonomies session.
Route::post('taxonomies/sessions/store' ,[Taxonomies_settingController::class , 'store_sessions'])->name('taxonomies_sessions.store');
Route::get('taxonomies/sessions/index' ,[Taxonomies_settingController::class , 'index_sessions'])->name('taxonomies_sessions.index');
Route::delete('taxonomies/sessions/delete/{id}' ,[Taxonomies_settingController::class , 'delete_sessions'])->name('taxonomies_sessions.delete');

// this is the routes  for teacher section
Route::post('taxonomies/teacher/store' ,[Teacher_settingController::class , 'store_teacher'])->name('teacher_setting.store');
Route::get('taxonomies/teacher/index', [Teacher_settingController::class, 'index_teacher']) ->name('teacher_setting.index');

// This is the route for course 

Route::post('taxonomies/course/store' ,[Taxonomies_settingController::class , 'store_course'])->name('taxonomies_course.store');
Route::get('taxonomies/course/index', [Taxonomies_settingController::class, 'index_course'])->name('taxonomies_course.index');
Route::delete('taxonomies/course/delete/{id}', [Taxonomies_settingController::class, 'delete_course'])->name('taxonomies_course.delete');

//This is the routes for teacher_course
Route::post('taxonomies/teacher_course/store', [Teacher_settingController::class, 'teacher_course_store'])->name('taxonomies_teacher_course.store');
Route::delete('taxonomies/teacher_course/delete/{id}', [Teacher_settingController::class, 'teacher_course_delete'])->name('taxonomies_teacher_course.delete');



//This is the route for platform modal
Route::post('platform_transaction/store', [PlatformController::class, 'platform_transaction_store'])->name('platform_transaction.store');

Route::get('platform/transactions/index', [PlatformController::class, 'platform_transaction_index'])->name('platform_transactions.index');
Route::post('/platform/transactions/{transaction}/restore', [PlatformController::class, 'platform_transaction_modal_store'])
    ->name('platform_transactions.restore');


Route::post('/currency/update', [PlatformController::class, 'platform_currency_update'])->name('platform_currency.update');


require __DIR__.'/auth.php';
