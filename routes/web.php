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



Route::get('/', [PickupController::class, 'index'])->name('pickup.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
