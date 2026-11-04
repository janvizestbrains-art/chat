<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LeaveController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;



Route::get('/login', [GuestController::class, 'login'])->name('login');
Route::post('/login', [GuestController::class, 'loginPost'])->name('loginPost');

Route::group(['middleware' => ['auth']], function () {
Route::get('/', [ChatController::class, 'index'])->name('index');
Route::get('/logout', [GuestController::class, 'logout'])->name('logout');
Route::post('/send-notification', [ChatController::class, 'sendNotification'])->name('sendNotification');
Route::get('/leave', [LeaveController::class, 'leave'])->name('leave');
Route::post('/apply-leave', [LeaveController::class, 'applyLeave'])->name('applyLeave');
Route::get('/leave-request', [LeaveController::class, 'leaveRequest'])->name('leaveRequest');
Route::get('/chat', [ChatController::class, 'chat'])->name('chat');
Route::get('/load-contacts', [ChatController::class, 'loadContact'])->name('loadContact');
Route::post('/chat-send', [ChatController::class, 'chatSend'])->name('chatSend');
Route::get('/load-chat', [ChatController::class, 'loadChat'])->name('loadChat');
Route::get('/message-read', [ChatController::class, 'messageRead'])->name('messageRead');

});
