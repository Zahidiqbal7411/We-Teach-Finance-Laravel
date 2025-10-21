<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormdataController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::post('/form/store' ,[FormdataController::class ,'store'])->name('form.submit');
// Route::post('/form' ,[FormdataController::class ,'index']);
// Route::get('/form/{id}/edit',[FormdataController::class ,'edit'])->name('form.edit');
// Route::post('/form/delete/{id}',[FormdataController::class ,'delete'])->name('form.delete');

Route::get('teacher/create', [TeacherController::class , 'create'])->name('teacher.create');
Route::get('platform/create', [PlatformController::class , 'create'])->name('platform.create');
Route::get('report/create', [ReportController::class , 'create'])->name('report.create');
Route::get('setting/create', [SettingController::class , 'create'])->name('setting.create');

Route::get('teacher_setting/create', [SettingController::class , 'create'])->name('teacher_setting.create');
Route::get('taxonomies_setting/create', [SettingController::class , 'create'])->name('taxonomies_setting.create');
Route::get('system_setting/create', [SettingController::class , 'create'])->name('system_setting.create');







require __DIR__.'/auth.php';
