<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Express_courseController;
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





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::post('/form/store' ,[FormdataController::class ,'store'])->name('form.submit');
    // Route::post('/form' ,[FormdataController::class ,'index']);
    // Route::get('/form/{id}/edit',[FormdataController::class ,'edit'])->name('form.edit');
    // Route::post('/form/delete/{id}',[FormdataController::class ,'delete'])->name('form.delete');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/update_currency', [DashboardController::class, 'update_currency'])->name('dashboard.update_currency');
    Route::post('/update_session', [DashboardController::class, 'update_session'])->name('dashboard.update_session');
    Route::resource('teacher', TeacherController::class);
    Route::resource('platform', PlatformController::class);
    Route::resource('report', ReportController::class);
    // Route::resource('setting', SettingController::class);



    // Route::get('/setting/create', [SettingController::class , 'create'])->name('setting.create');

    // Route::get('teacher_setting/create', [SettingController::class, 'create'])->name('teacher_setting.create');
    // Route::get('taxonomies_setting/create', [SettingController::class, 'create'])->name('taxonomies_setting.create');
    // Route::get('system_setting/create', [SettingController::class, 'create'])->name('system_setting.create');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('setting.create');
    Route::get('/settings/teacher', [Teacher_settingController::class, 'create'])->name('teacher_setting.create');
    Route::get('/settings/taxonomies', [Taxonomies_settingController::class, 'create'])->name('taxonomies_setting.create');
    Route::get('/settings/system', [System_settingController::class, 'create'])->name('system_setting.create');



    // Developer personal comments: this is the routes for setting updates.
    Route::post('security/{id}/update', [System_settingController::class, 'security_update'])->name('security_setting.update');
    Route::post('currency/update', [System_settingController::class, 'currency_update']);
    Route::post('/notification-settings/update', [System_settingController::class, 'notification_settings_update'])->name('notification_settings.update');


    //Developer personal comments: This is the routes for taxonomies educational system.
    Route::post('taxonomies/educational_systems/store', [Taxonomies_settingController::class, 'store_educational_systems'])->name('taxonomies_educational_systems.store');


    // For storing teacher data (POST request)
    Route::post('/settings/teacher/store', [Teacher_settingController::class, 'store_teacher'])
        ->name('teacher_setting.store');
    Route::get('/teachers/index_teacher', [Teacher_settingController::class, 'index_teacher'])->name('teacher.index_teacher');




    Route::get('taxonomies/educational_systems/index', [Taxonomies_settingController::class, 'index_educational_systems'])->name('taxonomies_educational_systems.index');
    Route::delete('taxonomies/educational_systems/delete/{id}', [Taxonomies_settingController::class, 'delete_educational_systems'])->name('taxonomies_educational_systems.delete');



    //Developer personal comments: This is the routes for taxonomies subject.
    Route::post('taxonomies/subjects/store', [Taxonomies_settingController::class, 'store_subjects'])->name('taxonomies_subjects.store');
    Route::get('taxonomies/subjects/index', [Taxonomies_settingController::class, 'index_subjects'])->name('taxonomies_subjects.index');
    Route::delete('taxonomies/subjects/delete/{id}', [Taxonomies_settingController::class, 'delete_subjects'])->name('taxonomies_subjects.delete');

    //Developer personal comments: This is the routes for taxonomies examination board.
    Route::post('taxonomies/examination_board/store', [Taxonomies_settingController::class, 'store_examination_board'])->name('taxonomies_examination_board.store');
    Route::get('taxonomies/examination_board/index', [Taxonomies_settingController::class, 'index_examination_board'])->name('taxonomies_examination_board.index');
    Route::delete('taxonomies/examination_board/delete/{id}', [Taxonomies_settingController::class, 'delete_examination_board'])->name('taxonomies_examination_board.delete');

    //Developer personal comments: This is the routes for taxonomies session.
    Route::post('taxonomies/sessions/store', [Taxonomies_settingController::class, 'store_sessions'])->name('taxonomies_sessions.store');
    Route::get('taxonomies/sessions/index', [Taxonomies_settingController::class, 'index_sessions'])->name('taxonomies_sessions.index');
    Route::delete('taxonomies/sessions/delete/{id}', [Taxonomies_settingController::class, 'delete_sessions'])->name('taxonomies_sessions.delete');

    // this is the routes  for teacher section
    Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::get('/teachers/{teacherId}/balance', [TeacherController::class, 'getCurrentBalance'])->name('teachers.balance');
    Route::get('/teachers/{teacher}/percourse', [TeacherController::class, 'getPerCourseTransactions'])->name('teachers.percourse');
    Route::get('/teachers/{id}', [TeacherController::class, 'getTeacherData'])->name('teachers.data');

    // Transactions
    Route::post('/transactions/store', [TeacherController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/delete/{id}', [TeacherController::class, 'deleteTransaction'])->name('transactions.delete');
    Route::post('/transactions/restore', [TeacherController::class, 'restore'])->name('transactions.restore');
    Route::post('/transactions/restore-percourse', [TeacherController::class, 'restorePerCourse'])->name('transactions.restore-percourse');

    // Teacher payouts
    Route::get('/teacher/payouts/{session_id}', [TeacherController::class, 'getPayouts'])->name('teacher.payouts.data');
    Route::delete('/teacher/payouts/delete/{id}', [TeacherController::class, 'deletePayout'])->name('teacher.payouts.delete');

    Route::post('/teacher/payouts/update-currency/{currency_id}', [TeacherController::class, 'updateCurrency'])
        ->name('teacher.payouts.updateCurrency');

    Route::post('/payouts/store', [TeacherController::class, 'storePayout'])->name('payouts.store');







    Route::post('/currency/update', [PlatformController::class, 'platform_currency_update'])->name('platform_currency.update');
    Route::get('/platform/per-course/details', [PlatformController::class, 'perCourseDetails'])->name('platform_transactions.per_course.details');


    // This is the route for course

    Route::post('taxonomies/course/store', [Taxonomies_settingController::class, 'store_course'])->name('taxonomies_course.store');
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

    // fetch per_cource
    Route::get('/platform/transactions/per-course', [PlatformController::class, 'perCourse'])
        ->name('platform_transactions.per_course');

    // fetch teacher balances
    Route::get('/balances/teacher', [PlatformController::class, 'teacherBalances'])->name('balances.teacher');

    // routes/web.php
    Route::get('/payouts/{session_id}', [PlatformController::class, 'getPayouts'])->name('payouts.data');
    Route::delete('/payouts/delete/{id}', [PlatformController::class, 'deletePayout'])->name('payouts.delete');


    //plateform payouts
    Route::post('/platform/payout', [PlatformController::class, 'platform_payout'])->name('platform_payout');

    // Get courses by teacher
    Route::get('/teacher/{teacherId}/courses', [PlatformController::class, 'getCoursesByTeacher'])->name('teacher.courses');


    // express course
    Route::get('express_course/create', [Express_courseController::class, 'create'])->name('express_course.create');
    Route::get('express_course/index', [Express_courseController::class, 'index'])->name('express_courses.index');
    Route::post('/express/transactions/store', [Express_courseController::class, 'store'])->name('express_course.transaction.store');





    //currency curd routes for settings
    Route::resource('currencies', CurrencyController::class)->only([
        'index',
        'store',
        'update',
        'destroy'
    ]);
    Route::get('currency_setting/create', [CurrencyController::class, 'create'])->name('currency_setting.create');
});




require __DIR__ . '/auth.php';
