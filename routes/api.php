<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Abdullah
Route::post('/register', [RegisterController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/user/update', [UpdateController::class, 'updateUser'])->middleware('auth:sanctum');
Route::put('/password/update', [UpdateController::class, 'updatePassword'])->middleware('auth:sanctum');
Route::get('/users/search', [UpdateController::class, 'search'])->middleware('auth:sanctum');
Route::get('/users/user/info/{id}', [UpdateController::class, 'userInfo'])->middleware('auth:sanctum');
Route::delete('/users/delete/{id}', [LoginController::class, 'delete'])->middleware('auth:sanctum');

// system admin Department
Route::post('/admin/depart/add', [DepartmentController::class, 'create'])->middleware('auth:sanctum');
Route::delete('/admin/depart/delete/{id}', [DepartmentController::class, 'deleteDepartment'])->middleware('auth:sanctum');
Route::get('/admin/departments', [DepartmentController::class, 'getDepartments'])->middleware('auth:sanctum');
Route::get('/admin/departments/{id}', [DepartmentController::class, 'searchDepartment'])->middleware('auth:sanctum');

//Mhmoudsyd-->Done Add SubjectController with requried functions
Route::post('/admin/subject/add', [SubjectController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/admin/subject/delete/{id}', [SubjectController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/admin/subjects', [SubjectController::class, 'showAllSubjects'])->middleware('auth:sanctum');
Route::get('/admin/subject', [SubjectController::class, 'show']);
Route::put('/admin/subject/update/{id}', [SubjectController::class, 'update'])->middleware('auth:sanctum');

// Account Maker
Route::get('/admin/users', [AccountMakerController::class, 'index'])->middleware('auth:sanctum');
Route::post('/admin/user/create', [AccountMakerController::class, 'store'])->middleware('auth:sanctum');
// Absence List
Route::get('/admin/users/absence', [AccountMakerController::class, 'show'])->middleware('auth:sanctum');


//doctor
Route::get('/doctor/subjects', [DoctorController::class, 'getSubs'])->middleware('auth:sanctum');
