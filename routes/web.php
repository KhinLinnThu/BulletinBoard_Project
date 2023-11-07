<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile-edit');
    Route::get('/changepassword', [ProfileController::class, 'showChangePasswordForm'])->name('password-show');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('password-change');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // For User
    Route::get('home', [UserController::class, 'homeCount'])->name('home');

    // For Post
    Route::post('postsearch', [PostController::class, 'searchPost'])->name('post-search');
    Route::get('postmanagement', [PostController::class, 'postManagement'])->name('post-management');
    Route::get('postcreate', [PostController::class, 'createPost'])->name('post-create');
    Route::post('postconfirm', [PostController::class, 'confirmPostInformation'])->name('post-confirm');
    Route::post('postcreatecomplete', [PostController::class, 'createPostComplete'])->name('post-complete');
    Route::get('postedit/{id}', [PostController::class, 'editPost'])->name('post-edit');
    Route::post('postupdate', [PostController::class, 'updatePostInformation'])->name('post-update');
    Route::delete('postdelete/{id}', [PostController::class, 'deletePost'])->name('post-delete');

    // Excel File Upload & Download
    Route::get('/fileimport', [ImportController::class, 'importView'])->name('import-view');
    Route::post('/import', [ImportController::class, 'import'])->name('import');
    Route::get('/export-posts', [ImportController::class, 'exportPosts'])->name('export-post');
});

Route::group(
    ['middleware' => ['auth', 'isAdmin']],
    function () {
        Route::post('usersearch', [UserController::class, 'searchUser'])->name('user-search');
        Route::get('usermanagement', [UserController::class, 'userManagement'])->name('user-management');
        Route::get('usercreate', [UserController::class, 'createUser'])->name('user-create');
        Route::post('userconfirm', [UserController::class, 'confirmUserInformation'])->name('user-confirm');
        Route::post('usercreatecomplete', [UserController::class, 'createUserComplete'])->name('user-complete');
        Route::get('useredit/{id}', [UserController::class, 'editUser'])->name('user-edit');
        Route::post('userupdate', [UserController::class, 'updateUserInformation'])->name('user-update');
        Route::delete('userdelete', [UserController::class, 'deleteUser'])->name('user-delete');
    }
);
