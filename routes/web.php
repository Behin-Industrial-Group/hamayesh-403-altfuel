<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('migrate', function(){
    Artisan::call('migrate');
    return redirect()->back();
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/check-national-code', [AuthController::class, 'checkNationalCode'])->name('check-national-code');

Route::get('/verify-code-form', [RegisteredUserController::class, 'verifyCodeForm'])->name('verify-code-form');
Route::post('/verify-code', [RegisteredUserController::class, 'verifyCode'])->name('verify-code');

Route::get('/generate-qr', [QRCodeController::class, 'generate'])->name('generate.qr');

require __DIR__.'/auth.php';
