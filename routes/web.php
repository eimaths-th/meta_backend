<?php

// namespace App\Http\Controllers;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AppDownloadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReceiptFormController;
use App\Http\Controllers\ParentRegisterController;
use App\Http\Controllers\SubjectPriceController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GodeyeContreoller;
use App\Http\Controllers\ReceiptSchoolController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecordtimeController;
use App\Http\Controllers\RetrospectiveCheckController;
use App\Http\Controllers\RouteToggleController;
use App\Http\Controllers\StdlogController;
use App\Http\Controllers\SuperMasterContrller;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\WorktimelogsController;


use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BonusStudentController;
use App\Http\Controllers\CheckReportStdController;
use App\Http\Controllers\FormManageController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AzureTTSController;
// use App\Http\Controllers\RouteToggleController;

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

Route::get('/home3', [HomeController::class, 'home3']);
Route::post('/attendance/import', [AttendanceController::class, 'import']);


Route::group(['middleware' => 'check.opening.date.time'], function () {
    // Dynamic slug-based route for all forms
    Route::get('/form/{slug}', [ReceiptFormController::class, 'showFormBySlug'])->name('form.show');
    // Route::get('/gelosea', [ReceiptFormController::class, 'gelosea'])->name('gelosea');


    // Route::get('/spelling-bee-islo', [ReceiptFormController::class, 'spelling_bee_islo'])->name('spelling-bee-islo');
    // Route::get('/stemco_science', [ReceiptFormController::class, 'stemco_science'])->name('stemco_science');
    // Route::get('/advance_english_grammar', [ReceiptFormController::class, 'advance_english_grammar'])->name('advance_english_grammar');
    // Route::get('/isocsea-imocsea-national-round-2025', [ReceiptFormController::class, 'isocsea_imocsea_national_round_2025'])->name('isocsea-imocsea-national-round-2025');
    // Route::get('/isocsea-imocsea-national-round', [ReceiptFormController::class, 'isocsea_imocsea_national_round'])->name('isocsea-imocsea-national-round');

    // // Testing route
    // Route::get('/testing-form-manage', [FormManageController::class, 'testing_form_manage'])->name('testing-form-manage');
});

Route::group(['middleware' => ['auth', 'checkUserId']], function () {
    Route::resource('studentBonus', BonusStudentController::class);
    Route::get('/studentBonus/schpid/{id}', [BonusStudentController::class, 'schpid'])->name('bonusRec');

    Route::get('/rec-time-logs', [WorktimelogsController::class, 'index'])->name('timelogs');
    Route::get('/update-late-time', [RecordtimeController::class, 'update_late_time'])->name('update_late_time');
    Route::get('/search-report-month-time', [RecordtimeController::class, 'search_reportMonthTime'])->name('search_reportMonthTime');
    Route::get('/find-UserRecTime/{user_id}/{status}/{month}/{year}', [RecordtimeController::class, 'find_UserRecTime'])->name('find_UserRecTime');
    Route::get('/find-StatusRecTime/{status}/{month}/{year}', [RecordtimeController::class, 'find_statusRecTime'])->name('find_statusRecTime');
    Route::get('/report-month-time', [RecordtimeController::class, 'reportTime'])->name('reportTime');
    Route::get('/testrec', [RecordtimeController::class, 'testrec'])->name('testrec');
    Route::get('/report-month-student', [StdlogController::class, 'reportMonthStd'])->name('reportMonthStd');
    Route::get('/searchr_reportMonthStd', [StdlogController::class, 'searchr_reportMonthStd'])->name('searchr_reportMonthStd');
    Route::get('/report-year-student', [StdlogController::class, 'reportYearStd'])->name('reportYearStd');
    Route::POST('/saveCheck', [CheckReportStdController::class, 'store'])->name('saveCheck');
    Route::get('/getDataRec/{id}', [CheckReportStdController::class, 'DataRec'])->name('getDataRec');
    Route::get('/fetch-checkbox-states', [CheckReportStdController::class, 'fetchCheckboxStates'])->name('fetchCheckboxStates');

    // Route::get('/stdLog-search', [StdlogController::class, 'searchTestLog'])->name('stdlog.search');
    Route::get('/report-reciept-student', [StdlogController::class, 'reportRecieptStd'])->name('reportRecieptStd');
    Route::get('/report-reciept-student-search', [StdlogController::class, 'reportRecieptStdSearch'])->name('reportRecieptStdSearch');
    Route::get('/report-reciept-student/{id}', [StdlogController::class, 'reportRecieptStdShow'])->name('reportRecieptStdShow');
});
Route::get('/stdLog-search', [StdlogController::class, 'search_id'])->name('searchTestLog');

Route::group(['middleware' => ['auth', 'switch']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});
Route::group(['middleware' => ['auth', 'outhome']], function () {

    Route::get('/updateStudentStatus', [App\Http\Controllers\HomeController::class, 'updateStudentStatus'])->name('updateStudentStatus');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/Home', [App\Http\Controllers\HomeController::class, 'home2'])->name('home2');
});


Route::get('/test-fn', [TestController::class, 'store'])->name('testFs')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); // test


Route::group(['middleware' => ['auth']], function () {
    Route::get('/search-rect', [RecordtimeController::class, 'search_rect'])->name('search_rect');


    Route::resource('recordtime', RecordtimeController::class);
    Route::resource('app-down-load', AppDownloadController::class);
    // Route::delete('/app-down-load/{id}', AppDownloadController::class,'destroy')->name('app-down-load.delete');

    // Route::delete('/recordtime/{id}', [RecordtimeController::class, 'destroy'])->name('recordtimes.destroy');

    //settime
    Route::get('/report-future-student', [StdlogController::class, 'reportFutureStd'])->name('reportFutureStd');
    Route::post('/save_times', [TimeController::class, 'saveTimes'])->name('save_times');
    Route::get('/forms-time', [TimeController::class, 'formsTimes'])->name('formsTimes');
    Route::get('/forms-control', [TimeController::class, 'formsControl'])->name('formsControl');
    Route::delete('/delete_control/{id}', [TimeController::class, 'deleteControl'])->name('delete_control');

    //std log
    Route::get('/report-future-student', [StdlogController::class, 'reportFutureStd'])->name('reportFutureStd');
    Route::get('/searchFuture', [StdlogController::class, 'searchFuture'])->name('searchFuture');
    Route::get('/search_future', [StdlogController::class, 'search_future'])->name('search_future');
    Route::get('/report-student', [StdlogController::class, 'index'])->name('report-student');
    Route::get('/search_status', [StdlogController::class, 'search_status'])->name('search_status');
    route::get('/Super-Master', [SuperMasterContrller::class, 'index'])->name('sm');
    route::get('/testmodal', [SuperMasterContrller::class, 'testModal'])->name('test_modal');
    route::get('/testReq', [SuperMasterContrller::class, 'testReq'])->name('testReq');
    Route::get('/perform-retrospective-check', [RetrospectiveCheckController::class, 'performRetrospectiveCheck']);
    Route::resource('stdlog', StdlogController::class);
    Route::get('stdlog/create', [StdlogController::class, 'create'])->name('stdlog_create');

    //user
    Route::get('/users', [EmployeeController::class, 'index'])->name('users');
    Route::get('/users/create', [EmployeeController::class, 'create'])->name('users.create');
    Route::get('/users/show', [EmployeeController::class, 'show'])->name('users.show');
    Route::get('/users/edit/{id}', [EmployeeController::class, 'edit'])->name('users.edit');
    Route::put('/users/save/{id}', [EmployeeController::class, 'update'])->name('users.save');
    Route::put('/users/msave/{id}', [EmployeeController::class, 'mupdate'])->name('users.msave');
    Route::post('/users/store', [EmployeeController::class, 'store'])->name('users.store');
    Route::delete('/users/destroy/{id}', [EmployeeController::class, 'destroy'])->name('users.destroy');
    Route::delete('/users/destroy_all', [EmployeeController::class, 'destroy_all'])->name('users.destroy_all');

    //reciept
    Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts');
    Route::get('/receipts_all', [ReceiptController::class, 'index_all'])->name('receipts_all');
    Route::get('/receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');
    Route::match(array('GET', 'POST'), '/receipts/print_day', [ReceiptController::class, 'print_day'])->name('receipts.print_day');
    Route::match(array('GET', 'POST'), '/receipts/print_month', [ReceiptController::class, 'print_month'])->name('receipts.print_month');
    Route::match(array('GET', 'POST'), '/receipts/print_field', [ReceiptController::class, 'print_field'])->name('receipts.print_field');
    Route::get('/receipts/show/{type}/{id}', [ReceiptController::class, 'show'])->name('receipts.show');
    Route::match(array('GET', 'POST'), '/receipts/show_day', [ReceiptController::class, 'show_day'])->name('receipts.show_day');
    Route::get('/receipts/edit/{id}/{type}', [ReceiptController::class, 'edit'])->name('receipts.edit');
    Route::get('/receipts/migrate/{id}', [ReceiptController::class, 'migrateReceipt'])->name('receipts.migrate');
    Route::put('/receipts/save/{id}', [ReceiptController::class, 'update'])->name('receipts.save');
    Route::post('/receipts/store', [ReceiptController::class, 'store'])->name('receipts.store');
    Route::post('/receipts/conv', [ReceiptController::class, 'conv'])->name('receipts.conv');
    Route::post('/receipts/import', [ReceiptController::class, 'importExcel'])->name('receipts.import');
    Route::delete('/receipts/destroy/{id}', [ReceiptController::class, 'destroy'])->name('receipts.destroy');
    Route::delete('/receipts/destroy_all', [ReceiptController::class, 'destroy_all'])->name('receipts.destroy_all');

    Route::get('/referent_url', [ReceiptFormController::class, 'referent_url'])->name('referent_url');
    Route::get('/generate_url', [ReceiptFormController::class, 'generateUrl'])->name('generate_url');
    Route::post('/generate_url', [ReceiptFormController::class, 'generateUrlSave'])->name('generate_url.save');
    Route::get('/referent_url/edit', [ReceiptFormController::class, 'referent_urlEdit'])->name('referent_url.edit');
    Route::post('/referent_url/edit', [ReceiptFormController::class, 'referent_urlEditSave'])->name('referent_url.edit.save');
    Route::delete('/referent_url/delete', [ReceiptFormController::class, 'referent_urlDelete'])->name('referent_url.delete');

    Route::get('/referent_code', [ReceiptFormController::class, 'referent_code'])->name('referent_code');
    Route::get('/generate_code', [ReceiptFormController::class, 'generate_code'])->name('generate_code');
    Route::post('/referent_code', [ReceiptFormController::class, 'referent_codeSave'])->name('referent_code.save');
    Route::get('/referent_code/edit', [ReceiptFormController::class, 'referent_codeEdit'])->name('referent_code.edit');
    Route::post('/referent_code/edit', [ReceiptFormController::class, 'referent_codeEditSave'])->name('referent_code.edit.save');
    Route::delete('/referent_code/delete', [ReceiptFormController::class, 'referent_codeDelete'])->name('referent_code.delete');

    //form manage
    // Route::resource('form-manage', FormManageController::class);
    Route::get('/form-manage', [FormManageController::class, 'index'])->name('form-manage.index');
    // form-manage.store
    Route::post('/form-manage/store', [FormManageController::class, 'store'])->name('form-manage.store');
    // form-manage.view
    Route::get('/form-manage/{id}', [FormManageController::class, 'view'])->name('form-manage.view');
    //destroy
    Route::post('/form-manage/destroy', [FormManageController::class, 'destroy'])->name('form-manage.destroy');
    Route::get('/select_route', [FormManageController::class, 'selectRoute'])->name('select_route');
    // Route::post('/create-form', [FormManageController::class, 'create'])->name('create-form');
    Route::match(['GET', 'POST'], '/create-form', [FormManageController::class, 'create'])->name('create-form');
    Route::get('/form-manage/{id}', [FormManageController::class, 'view'])->name('form-manage.view');
    Route::post('/create-option-grade', [FormManageController::class, 'createOptionGrade'])->name('create-option-grade');
    Route::post('/create-bulk-grades', [FormManageController::class, 'createBulkGrades'])->name('create-bulk-grades');
    Route::get('/get-form-grades', [FormManageController::class, 'getFormGrades'])->name('get-form-grades');
    Route::post('/edit-option-grade', [FormManageController::class, 'editOptionGrade'])->name('edit-option-grade');
    Route::post('/delete-option-grade', [FormManageController::class, 'deleteOptionGrade'])->name('delete-option-grade');
    Route::post('/delete-all-grades', [FormManageController::class, 'deleteAllGrades'])->name('delete-all-grades');

    Route::post('/create-option-package', [FormManageController::class, 'createOptionPackage'])->name('create-option-package');
    Route::post('/edit-option-package', [FormManageController::class, 'editOptionPackage'])->name('edit-option-package');
    Route::post('/delete-option-package', [FormManageController::class, 'deleteOptionPackage'])->name('delete-option-package');
    Route::post('/delete-all-packages', [FormManageController::class, 'deleteAllPackages'])->name('delete-all-packages');

    // Package-Grade linking routes
    Route::post('/link-package-grades', [FormManageController::class, 'linkPackageGrades'])->name('link-package-grades');
    Route::get('/get-package-linked-grades', [FormManageController::class, 'getPackageLinkedGrades'])->name('get-package-linked-grades');
});

//form


Route::get('/cambridge/line', [ReceiptFormController::class, 'cambridge'])->name('cambridge.line');
Route::post('/form/upload', [ReceiptFormController::class, 'fileStore'])->name('form.upload');
Route::post('/form/upload/api', [ReceiptFormController::class, 'fileStoreAPI'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('form.upload.api');
Route::post('/form/upload/delete', [ReceiptFormController::class, 'fileDestroy'])->name('form.delete');
Route::post('/form/store', [ReceiptFormController::class, 'store'])->name('form.store');
Route::post('/form/storeFormManage', [ReceiptFormController::class, 'storeFormManage'])->name('form.storeFormManage');
Route::get('/form/complete/{sfield}', [ReceiptFormController::class, 'show'])->name('form.complete');
Route::get('/form/completed/{sfield}', [ReceiptFormController::class, 'showFormManage'])->name('form.completed');
Route::get('/form/complete1', [ReceiptFormController::class, 'show1'])->name('form.complete1');

Route::post('/form/store1', [ReceiptFormController::class, 'store1'])->name('form.store1');

Route::get('/receipts_form', [ReceiptFormController::class, 'index'])->name('receipts_form');
Route::get('/receipts_form_all', [ReceiptFormController::class, 'index_all'])->name('receipts_form_all');
Route::get('/receipts_form/edit/{id}', [ReceiptFormController::class, 'edit'])->name('receipts_form.edit');
Route::delete('/receipts_form/destroy/{id}', [ReceiptFormController::class, 'destroy'])->name('receipts_form.destroy');
Route::delete('/receipts_form/destroy_all', [ReceiptFormController::class, 'destroy_all'])->name('receipts_form.destroy_all');
Route::delete('/receipts_form/export', [ReceiptFormController::class, 'exportForm'])->name('receipts_form.export');
Route::post('/receipts_form/store', [ReceiptFormController::class, 'create'])->name('receipts_form.store');
Route::post('/receipts_form/update', [ReceiptFormController::class, 'update'])->name('receipts_form.update');
Route::put('/receipt_form/delete_img/{filename}/{id}', [ReceiptFormController::class, 'deleteImg'])->name('receipt_form.delete_img');
Route::post('/receipts_form/resend-mail/{id}', [ReceiptFormController::class, 'reSendMail'])->name('receipts_form.resend_mail');

Route::group(array('domain' => 'form.infinitebrain.co.th'), function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});
Route::get('/send-line-message', [LineController::class, 'sendMessage'])->name('send.line.message');
Route::get('/test-view', [LineController::class, 'testView'])->name('line.testView');
// Route::get('/generate-tts', [LineController::class, 'generateTTS'])->name('line.generate-tts');


Route::post('/generate-tts', [AzureTTSController::class, 'generate'])->name('generate.tts');

Route::post('/webhook', [LineController::class, 'webhook'])->name('line.webhook');

// Route::get('/webhook', function () {
//     return response('Webhook verified', 200);
// });

//Route::get('/', [EmployeeController::class, 'index']);

Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

//Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('/parent-register', [ParentRegisterController::class, 'register'])->name('parentregister');
Route::post('/parent-register/store', [ParentRegisterController::class, 'store'])->name('parentregister.store');
Route::get('/parent-register/complete', [ParentRegisterController::class, 'show'])->name('parentregister.complete');


//Route for normal user//
//Route::group(['middleware' => ['auth']], function () {
//   Route::get('/home', [App\Http\Controllers\CourseController::class, 'index'])->name('home');
//});

//Route for admin
/*Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);
    });
});*/

// Route::group(['middleware' => 'inactivity'], function () {
//     // Routes that require inactivity timeout check

// });


// Route::get('/search_status/{month}/{year}', [StdlogController::class, 'search_status'])->name('search_status');





Route::get('/school', [SchoolController::class, 'index'])->name('school');



// Route::prefix('google')->name('google.')->group( function(){
//     Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
//     Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
// });
Route::get('/login/google', [GoogleController::class, 'loginWithGoogle'])->name('google.login');
Route::get('/login/google/callback', [GoogleController::class, 'callbackFromGoogle'])->name('google.callback');

//Auth::routes();
Route::get('/login/parent', [LoginController::class, 'showParentLoginForm'])->name('login.parent');
Route::post('/login/parent', [LoginController::class, 'parentLogin']);
Route::get('/login/parent/logout', [LoginController::class, 'ParentsignOut'])->name('parent.logout');


// Route::view('/home', 'home')->middleware('auth');
////Route::view('/parent', 'parent')->middleware('auth');
Route::get('/parent', [SchoolController::class, 'index'])->name('parent');
Route::group(array('domain' => 'school.infinitebrain.co.th'), function () {
    Route::get('/', [App\Http\Controllers\SchoolController::class, 'index']);
});

Route::post('/parent/save', [SchoolController::class, 'update'])->name('parent.save');
Route::post('/parent/saveparent', [SchoolController::class, 'updateParent'])->name('parent.saveparent');

// Route::put('/students/save/{id}', [StudentController::class, 'update'])->name('students.save');

Route::get('/comment', [CommentController::class, 'index'])->name('comment');
Route::get('/comment/edit/{id}', [CommentController::class, 'edit'])->name('comment.edit');
Route::post('/comment/store1', [CommentController::class, 'store1'])->name('comment.store1');
Route::put('/comment/save/{id}', [CommentController::class, 'update'])->name('comment.save');
Route::post('/comment/upload', [CommentController::class, 'fileStore'])->name('comment.upload');
Route::post('/comment/upload/delete', [CommentController::class, 'fileDestroy'])->name('comment.delete');
Route::delete('/comment/destroy/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
Route::delete('/comment/destroy_all', [CommentController::class, 'destroy_all'])->name('comment.destroy_all');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
