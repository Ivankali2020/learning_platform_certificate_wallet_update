<?php

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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('detail/course', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.course');
Route::get('user/cart', [App\Http\Controllers\HomeController::class, 'UserCart'])->name('user.cart');

Route::group(['middleware' => ['auth']],function (){

    Route::resource('category',\App\Http\Controllers\CategoryController::class);
    Route::resource('course',\App\Http\Controllers\CourseController::class);
    Route::resource('user',\App\Http\Controllers\UserController::class);
    Route::resource('product',\App\Http\Controllers\ProductController::class);
    Route::resource('cart',\App\Http\Controllers\CartController::class);
    Route::resource('enrollment',\App\Http\Controllers\EnrollmentController::class);
    Route::get('user/enrollment/list',[\App\Http\Controllers\EnrollmentController::class,'userEnrollment'])->name('user.enrollment');
    Route::get('enrollment/custom/show/{id}',[\App\Http\Controllers\EnrollmentController::class,'enrollmentCustomShow'])->name('enrollment.custom.show');

    Route::post('/user/upgradeAdmin', [\App\Http\Controllers\UserController::class, 'upgradeAdmin'])->name('user.upgradeAdmin');
    Route::get('certificate/user/{id}',[\App\Http\Controllers\UserController::class,'certificate'])->name('certificate.request');
    Route::resource('course/curriculum',\App\Http\Controllers\CourseCurriculumController::class);
    Route::get('course/curriculum/custom/{id}',[\App\Http\Controllers\CourseCurriculumController::class,'customCreate'])->name('custom.create');
});

Route::get('/redirect/{name}',[\App\Http\Controllers\Auth\LoginController::class,'redirect'])->name('redirect.name');
Route::get('/callback/{name}',[\App\Http\Controllers\Auth\LoginController::class,'callBack'])->name('callback.name');

Route::post('course/heart/',[\App\Http\Controllers\CourseController::class,'heartGive'])->name('course.heart');

