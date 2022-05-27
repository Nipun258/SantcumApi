<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjectController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register",[StudentController::class, "register"])->name('student.registeration');
Route::post("login",[StudentController::class, "login"])->name('student.login');

Route::group(["middleware" => ["auth:sanctum"]], function(){

   Route::get("profile",[StudentController::class, "profile"])->name('student.profile');
   Route::get("logout",[StudentController::class, "logout"])->name('student.logout');


   ////project releted route
   Route::post("project/create",[ProjectController::class, "createProject"])->name('project.create');
   Route::get("project/list",[ProjectController::class, "listProject"])->name('project.list');
   Route::get("project/single/{id}",[ProjectController::class, "singleProject"])->name('project.single');
   Route::delete("project/delete/{id}",[ProjectController::class, "deleteProject"])->name('project.delete');

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
