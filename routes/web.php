<?php

use App\Http\Controllers\Admin\blog\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\blog\FilterController;
use App\Http\Controllers\Admin\blog\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\blog\TagController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('local/{language}', LocalizationController::class)->name('locale.switch');


Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, '__invoke'])->name('dashboard');
        Route::post('category/sort', [CategoryController::class, 'sort'])->name('category.sort');
        Route::get('category/select', [CategoryController::class, 'select'])->name('category.select');
        Route::get('category/list', [CategoryController::class, 'list'])->name('category.list');
        Route::resource('category', CategoryController::class)->except(['create']);

        // Route::prefix('tags')->as('tags.')->group(function () {
        //     Route::get('/', [TagController::class, 'index'])->name('index');
        // });
        Route::resource('tags', TagController::class)->except(['create', 'show', 'edit']);
        Route::get('tags/list', [TagController::class, 'list'])->name('tags.list');
        Route::resource('post', PostController::class);
        Route::get('post/list/{id}', [PostController::class, 'list'])->name('post.list');
        Route::post('tiny', [PostController::class, 'tinyupload'])->name('post.tiny');
        // Route::any('post', [PostController::class, 'index']);

        /**
         * Filter Page
         */
        Route::resource('filter',FilterController::class);

        Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });

Route::prefix('setting')->as('setting.')->group(function () {
    Route::get('/sessionConfig', [SettingController::class, 'sessionConfig'])->name('sessionConfig');
});
