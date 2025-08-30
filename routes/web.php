<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

// Public routes
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/resources', function () {
    return view('resources');
})->name('resources');

Route::get('/forum', function () {
    return view('forum');
})->name('forum');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/alumni', function () {
    return view('alumni');
})->name('alumni');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::view('dashboard', 'dashboard')
    ->middleware(['admin', 'auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
