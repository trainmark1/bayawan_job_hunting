<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Job;

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



// All jobs
Route::get('/', [JobController::class, 'index']);
// Show Create Form
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
// Store job Data
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
// Show Edit Form
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware('auth');
// Update job
Route::put('/jobs/{job}', [JobController::class, 'update'])->middleware('auth');
// Delete job
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->middleware('auth');
// Manage jobs
Route::get('/jobs/manage', [JobController::class, 'manage'])->middleware('auth');
// Single job
Route::get('/jobs/{job}', [JobController::class, 'show']);
// Show Register/Create Form
Route::get('/register', [UsersController::class, 'create'])->middleware('guest');
// Create New User
Route::post('/users', [UsersController::class, 'store']);
// Log User Out
Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth');
// Show Login Form
Route::get('/login', [UsersController::class, 'login'])->name('login')->middleware('guest');
// Log In User
Route::post('/users/authenticate', [UsersController::class, 'authenticate']);
