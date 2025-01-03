<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/assign/{token}', \App\Livewire\ClientAssign::class);
Route::get('/assign', \App\Livewire\InsertToken::class);
Route::view('/endmessage', 'endemessage');

require __DIR__.'/auth.php';
