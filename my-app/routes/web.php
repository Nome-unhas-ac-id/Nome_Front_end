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

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/images/{filename}', function (string $filename) {
    $path = public_path('images/'.$filename);
    if (file_exists($path)) {
        $mime = str_ends_with($filename, '.svg') ? 'image/svg+xml' : (str_ends_with($filename, '.png') ? 'image/png' : mime_content_type($path));

        return response()->file($path, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
    abort(404);
})->where('filename', '.*');
