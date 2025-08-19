<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommonTaskFrameworkController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CtfDataStoreController;
use App\Http\Controllers\HomeChartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
Route::post('/submit-form', [CommonTaskFrameworkController::class, 'store'])->name('tasks.store');

Route::post('/upload', [CommonTaskFrameworkController::class, 'store'])->name('upload.store');
Route::post('/ctf-data-store', [CtfDataStoreController::class, 'store'])->name('ctfdata.store');

Route::post('/submit-and-execute/{id}', [CommonTaskFrameworkController::class,
'submitAndExecute'])->name('admin.submitAndExecute');

Route::get('/admin/download-csv/{id}', [CommonTaskFrameworkController::class,'downloadCsv'])->name('admin.downloadCsv');
Route::get('/admin/download-py/{id}', [CommonTaskFrameworkController::class, 'downloadPy'])->name('admin.downloadPy');
Route::get('/ctfdata', [CtfDataStoreController::class, 'index'])->name('ctfdata.index');


Route::get('/', function () {
    return view('client.home');
});
Route::get('/graph', function () {
    return view('client.treegraph');
});

Route::get('/contact',[HomeController::class,'index'])->name('contactIndex');
Route::post('/contact',[HomeController::class,'store'])->name('contactStore');
Route::delete('/contact/delete/{id}',[HomeController::class,'destroy'])->name('tasks.destroy');
Route::delete('/tasks/bulk-delete', [HomeController::class, 'bulkDelete'])->name('tasks.bulkDelete');


Route::get('/factor-returns', function () {
    return view('client.factor');
});
Route::get('/stock-char', function () {
    return view('client.stock');
});

Route::get('/performance-of-factors', [ChartController::class, 'showChart'])->name('analysis.showChart');
Route::get('/analysis', [ChartController::class, 'showCharts'])->name('performanceoffactors.showCharts');

Route::get('/guide-R', function () {
    return view('client.guideR');
});
Route::get('/guide-python', function () {
    return view('client.guidepython');
});

Route::get('/common-task-framework', function () {
    return view('client.commontaskframework');
})->name("commontaskframework");

Route::get('/request-ctf-data', function () {
    return view('client.requestCtfData');
})->name("requestCtfData");

Route::get('/check', function () {
return view('client.multimul');
});

Route::get('/factors-to-watch', function () { 
    return view('client.factorstowatch');
});

Route::post('download-file',[FileController::class,'downloadFile'])->name('factors.download-file');
Route::post('get-graph-data',[FileController::class,'getDataForGraph'])->name('analysis.get-graph-data');
Route::post('/get-alpha-graph-data', [FileController::class,
'getAlphaGraphData'])->name('analysis.get-alpha-graph-data');
Route::post('factors-data-to-watch',[FileController::class,'factorsDataToWatch'])->name('analysis.factors-data-to-watch');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('home');
    Route::get('/factors', [HomeController::class, 'factorsCheck'])->name('admin.uploads.index');
    
    Route::get('/admin/update', [App\Http\Controllers\HomeController::class, 'editAdmin'])->name('admin.edit');
    Route::post('/admin/update', [App\Http\Controllers\HomeController::class, 'updateAdmin'])->name('admin.update');


    Route::get('/message', [App\Http\Controllers\HomeController::class, 'message'])->name('message');
    
    Route::resource('roles', RoleController::class);
    
    Route::resource('users', UserController::class);
    
});
