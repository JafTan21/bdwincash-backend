<?php

use App\Http\Controllers\ActivatorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\EvenOddController;
use App\Http\Controllers\GameHistoryController;
use App\Http\Controllers\GameSettingController;
use App\Http\Controllers\HeadTailController;
use App\Http\Controllers\KingsController;
use App\Http\Controllers\LudoController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Models\BalanceTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/get-withdraws', [WithdrawController::class, 'withdraws']);
Route::apiResource('withdraw', WithdrawController::class);

Route::post('/get-deposits', [DepositController::class, 'deposits']);
Route::apiResource('deposit', DepositController::class);

Route::post('/get-headtails', [HeadTailController::class, 'headtails']);
Route::apiResource('headtail', HeadTailController::class);

Route::post('/get-evenOdds', [EvenOddController::class, 'evenOdds']);
Route::apiResource('evenOdd', EvenOddController::class);

Route::post('/get-kings', [KingsController::class, 'kings']);
Route::apiResource('kings', KingsController::class);

Route::post('/get-ludos', [LudoController::class, 'ludos']);
Route::apiResource('ludo', LudoController::class);

Route::post('/toggle-user', [UserController::class,'toggleUser']);
Route::post('/get-user', [UserController::class,'getUser']);
Route::post('check-is-admin', [UserController::class, 'checkAdmin']);
Route::post('check-is-user', [UserController::class, 'checkUser']);
Route::post('/get-users', [UserController::class, 'getUsers']);
Route::post('/change-password', [UserController::class, 'changePassword']);
Route::apiResource('user', UserController::class);

Route::post('/get-payment-methods', [PaymentMethodController::class, 'getPaymentMethods']);
Route::apiResource('paymentMethod', PaymentMethodController::class);

Route::post('/get-game-settings', [GameSettingController::class, 'getGameSettings']);
Route::apiResource('gameSetting', GameSettingController::class);

Route::post('/get-game-history', [GameHistoryController::class, 'getGameHistory']);

Route::post('/get-dashboard-details', [AdminDashboardController::class, 'index']);
Route::post('/get-deposit-withdraw-notification', [AdminDashboardController::class, 'withdrawDepositNotificationCount']);

Route::post('/get-notice', [NoticeController::class, 'getNotice']);
Route::resource('notice', NoticeController::class);

Route::post('/get-balance-transfers', [BalanceTransferController::class, 'getBalanaceTransfers']);
Route::apiResource('balanceTransfer', BalanceTransferController::class);

Route::post('get-settings', [SettingController::class, 'getSettings']);
Route::apiResource('setting', SettingController::class);

Route::post('/get-notification-count', [NotificationController::class, 'getNotificationCount']);
Route::post('/get-notifications', [NotificationController::class, 'getNotifications']);
Route::apiResource('notification', NotificationController::class);

Route::post('/check-security-key', [ActivatorController::class, 'check']);
Route::apiResource('activator', ActivatorController::class);
