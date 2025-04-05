<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;

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

// profile
Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

Route::group(['middleware' => 'auth'], function() {
    // follow
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');

    // post
    Route::get('/', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
});


// my playing
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/test', function () {
   $users = User::all();
print_r($users[0]->id);
});

Route::get('updateuser', function () {
    $user = User::find(1);
    $password = 'test1password';
    $password = Hash::make($password);
    $user->password = $password;
    $user->update();
});