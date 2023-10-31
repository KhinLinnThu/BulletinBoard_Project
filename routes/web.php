<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('auth/login');
    });
Route::get('login', [Controller::class, 'showlogin'])->name('login');
Route::post('login', [Controller::class, 'login']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/changepassword', [ProfileController::class, 'showChangePasswordForm'])->name('password#show');
    Route::post('/change-password', [ProfileController::class, 'passwordChange'])->name('password#change');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');
});
// For User
Route::get('home', [Controller::class, 'homeCount'])->name('home');

// For Post
Route::post('postsearch', [PostController::class, 'postSearch'])->name('post#search');
Route::get('postmanagement', [PostController::class, 'postManagement'])->name('post#management');
Route::get('postcreate', [PostController::class, 'postCreate'])->name('post#create');
Route::post('postconfirm', [PostController::class, 'postConfirm'])->name('post#confirm');
Route::post('postcreatecomplete', [PostController::class, 'postCreateComplete'])->name('post#complete');
Route::get('postedit/{id}', [PostController::class, 'postEdit'])->name('post#edit');
Route::post('postupdate', [PostController::class, 'postUpdate'])->name('post#update');
Route::delete('postdelete/{id}', [PostController::class, 'postDelete'])->name('post#delete');

// Excel File Upload & Download
Route::get('/fileimport', [ImportController::class, 'importView'])->name('importview');
Route::post('/import', [ImportController::class, 'import'])->name('import');
Route::get('/export-posts', [ImportController::class, 'exportPosts'])->name('exportpost');

Route::group(
    ['middleware' => ['auth', 'isAdmin']],
    function () {
        Route::post('usersearch', [Controller::class, 'userSearch'])->name('user#search');
        Route::get('usermanagement', [Controller::class, 'userManagement'])->name('user#management');
        Route::get('usercreate', [Controller::class, 'userCreate'])->name('user#create');
        Route::post('userconfirm', [Controller::class, 'userConfirm'])->name('user#confirm');
        Route::post('usercreatecomplete', [Controller::class, 'userCreateComplete'])->name('user#complete');
        Route::get('useredit/{id}', [Controller::class, 'userEdit'])->name('user#edit');
        Route::post('userupdate', [Controller::class, 'userUpdate'])->name('user#update');
        Route::delete('userdelete', [Controller::class, 'userDelete'])->name('user#delete');
    }
);
