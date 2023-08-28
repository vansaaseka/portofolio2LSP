<?php

use App\Http\Controllers\api\AdminCategoryController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FaqController;
use App\Http\Controllers\api\PostCategoryController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\TicketController;
use App\Http\Controllers\api\TopicController;
use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\CommentController;
use App\Http\Controllers\api\ReportController;
use App\Http\Controllers\api\StaffController;
use App\Http\Controllers\api\UnitController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login', [AuthApiController::class, 'login']);

// FAQ
Route::resource('/faq', FaqController::class)->only(['index']);

Route::get('/counted-data', [ViewController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/chart-data', [ViewController::class, 'chartData']);
    
    // AUTH
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // POST CATEGORIES
    Route::resource('/categories', PostCategoryController::class)->only([
        'index'
    ]);

    // TICKETS
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::get('/tickets/{ticket:slug}', [TicketController::class, 'show']);
    Route::patch('/tickets/{ticket:slug}', [TicketController::class, 'update']);

    // POSTS
    Route::resource('/posts', PostController::class);

    // TOPICS
    Route::resource('/topics', TopicController::class)->only(
        'index'
    );

    Route::post('/comments/post', [CommentController::class, 'storePost']);
    
    Route::post('/comments/ticket', [CommentController::class, 'storeTicket']);
    
    Route::post('/tickets', [TicketController::class, 'store']);

    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report', [ReportController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'user'])->group(function () {
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // TOPICS
    Route::resource('/topics', TopicController::class)->except(
        'index', 'show'
    );

    Route::put('/topics/{topic:slug}/toggle',[TopicController::class, 'toggleStatus']);

    // USERS
    Route::resource('/users', UserController::class)->except([
        'show'
    ]);
});

Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    // POST CATEGORIES
    Route::resource('/categories', PostCategoryController::class)->except([
        'index', 'show'
    ]);
    Route::put('/categories/{category:slug}/toggle',[PostCategoryController::class, 'toggleStatus']);

    // FAQ
    Route::resource('/faq', FaqController::class)->except(['index']);

    // STAFF
    Route::resource('/staff', StaffController::class)->except([
        'show'
    ]);
    
    Route::resource('/staff-ahli', AdminCategoryController::class)->except([
        'show'
    ]);
    
    Route::get('/staff-ahli/categories', [AdminCategoryController::class, 'categoryAdmin']);

    Route::resource('/units', UnitController::class);

    Route::get('/posts/unit/{unit:slug}', [PostController::class, 'postsUnit']);

    Route::get('/tickets/unit/{unit:slug}', [TicketController::class, 'ticketsUnit']);
});

Route::middleware(['auth:sanctum', 'all_admin'])->group(function () {
   
});