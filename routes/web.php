<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Models\ForumPost;

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

Route::get('/forum/{post}', function (int $post) {
    return view('forum-post', ['post' => ForumPost::findOrFail($post)]);
})->name('forum.post');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/alumni', function () {
    return view('alumni');
})->name('alumni');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/store', function () {
    return view('store');
})->name('store');

Route::middleware(['admin', 'auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard.home')->name('dashboard');
    Route::view('/dashboard/announcements', 'dashboard.announcements')->name('dashboard.announcements');
    Route::view('/dashboard/merch', 'dashboard.merch')->name('dashboard.merch');
    Route::view('/dashboard/news-articles', 'dashboard.news-articles')->name('dashboard.news-articles');
    Route::view('/dashboard/gallery-items', 'dashboard.gallery-items')->name('dashboard.gallery-items');
    Route::view('/dashboard/events', 'dashboard.events')->name('dashboard.events');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
