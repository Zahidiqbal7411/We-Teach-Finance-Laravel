<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormdataController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;


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







require __DIR__.'/auth.php';
