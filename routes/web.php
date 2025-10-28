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
Route::post('currency/{id}/update', [System_settingController::class,'currency_update'])->name('currency_setting.update');
Route::post('/notification-settings/update', [System_settingController::class, 'notification_settings_update'])->name('notification_settings.update');


//Developer personal comments: This is the routes for taxonomies educational system.
Route::post('taxonomies/educational_systems/store' ,[Taxonomies_settingController::class , 'store_educational_systems'])->name('taxonomies_educational_systems.store');
Route::get('taxonomies/educational_systems/index' ,[Taxonomies_settingController::class , 'index_educational_systems'])->name('taxonomies_educational_systems.index');
Route::delete('taxonomies/educational_systems/delete/{title}' ,[Taxonomies_settingController::class , 'delete_educational_systems'])->name('taxonomies_educational_systems.delete');




Route::post('taxonomies/subjects/store' ,[Taxonomies_settingController::class , 'store_subjects'])->name('taxonomies_subjects.store');
Route::post('taxonomies/examination_boards/store' ,[Taxonomies_settingController::class , 'store_examination_boards'])->name('taxonomies_examination_boards.store');
Route::post('taxonomies/sessions/store' ,[Taxonomies_settingController::class , 'store_sessions'])->name('taxonomies_sessions.store');


require __DIR__.'/auth.php';
