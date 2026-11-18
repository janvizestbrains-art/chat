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
Route::get('/message-edit/{id}', [ChatController::class, 'messageUpdate'])->name('messageUpdate');
Route::Post('/message-delete-for-me',[ChatController::class,'messageDeleteForMe'])->name('messageDeleteForMe');
Route::POST('/message-delete-for-everyone',[ChatController::class,'messageDeleteForEveryone'])->name('messageDeleteForEverone');
Route::POST('/clear-chat',[ChatController::class,'clearChat'])->name('clearChat');
Route::POST('/message-react',[ChatController::class,'messageReact'])->name("messageReact");
Route::POST('/message-remove-react',[ChatController::class,'messageRemoveReact'])->name('messageRemoveReact');
Route::POST('/message-star',[ChatController::class,'messageStar'])->name('messageStar');



Route::post('/leave/{leave}/status', [LeaveController::class, 'updateStatus'])
    ->name('leave.updateStatus');
});
