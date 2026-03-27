<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;


Route::get('/', [PickupController::class, 'index'])->name('pickup.index');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('dictionaries', DictionaryController::class);
    Route::resource('dictionaries.words', WordController::class);
    Route::get('/join', [InvitationController::class, 'show'])->name('invitations.show');
    Route::post('/join', [InvitationController::class, 'join'])->name('invitations.join');
    // Route::get('/pickup', [PickupController::class, 'index'])->name('pickup.index');
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/gemini/convert', [GeminiController::class, 'convert'])->name('gemini.convert');
    Route::post('/dictionaries/{dictionary}/words/{word}/reactions', [ReactionController::class, 'store'])->name('reactions.store');
    
});

// routes/web.php の一番下にこれを上書きしてください
Route::get('/design-check', function () {
    $user = (object)[
        'name' => 'イトヲカシ太郎',
        'email' => 'itowokashi@example.com',
    ];

    // レイアウト（ガワ）を guest-layout に指定し、
    // その中身（slot）として delete-user-form を流し込みます
    return view('layouts.guest', [
        'slot' => view('profile.partials.delete-user-form', ['user' => $user])
    ]);
});

require __DIR__.'/auth.php';
