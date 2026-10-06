<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes for Nome AI Meeting Transcription
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/memo', function () {
    return view('history');
})->name('memo');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/add-memo', function () {
    return view('add-memo');
})->name('add-memo');

Route::get('/preview', function () {
    return view('preview');
})->name('preview');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');
