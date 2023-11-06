<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

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
    Route::get('login', [LoginController::class, 'showlogin'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile_edit');
    Route::get('/changepassword', [ProfileController::class, 'showChangePasswordForm'])->name('password_show');
    Route::post('/change-password', [ProfileController::class, 'passwordChange'])->name('password_change');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // For User
    Route::get('home', [Controller::class, 'homeCount'])->name('home');

    // For Post
    Route::post('postsearch', [PostController::class, 'postSearch'])->name('post_search');
    Route::get('postmanagement', [PostController::class, 'postManagement'])->name('post_management');
    Route::get('postcreate', [PostController::class, 'postCreate'])->name('post_create');
    Route::post('postconfirm', [PostController::class, 'postConfirm'])->name('post_confirm');
    Route::post('postcreatecomplete', [PostController::class, 'postCreateComplete'])->name('post_complete');
    Route::get('postedit/{id}', [PostController::class, 'postEdit'])->name('post_edit');
    Route::post('postupdate', [PostController::class, 'postUpdate'])->name('post_update');
    Route::delete('postdelete/{id}', [PostController::class, 'postDelete'])->name('post_delete');

    // Excel File Upload & Download
    Route::get('/fileimport', [ImportController::class, 'importView'])->name('importview');
    Route::post('/import', [ImportController::class, 'import'])->name('import');
    Route::get('/export-posts', [ImportController::class, 'exportPosts'])->name('exportpost');
});

Route::group(
    ['middleware' => ['auth', 'isAdmin']],
    function () {
        Route::post('usersearch', [Controller::class, 'userSearch'])->name('user_search');
        Route::get('usermanagement', [Controller::class, 'userManagement'])->name('user_management');
        Route::get('usercreate', [Controller::class, 'userCreate'])->name('user_create');
        Route::post('userconfirm', [Controller::class, 'userConfirm'])->name('user_confirm');
        Route::post('usercreatecomplete', [Controller::class, 'userCreateComplete'])->name('user_complete');
        Route::get('useredit/{id}', [Controller::class, 'userEdit'])->name('user_edit');
        Route::post('userupdate', [Controller::class, 'userUpdate'])->name('user_update');
        Route::delete('userdelete', [Controller::class, 'userDelete'])->name('user_delete');
    }
);
