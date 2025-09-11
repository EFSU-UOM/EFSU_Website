<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Models\ForumPost;
use App\Models\LostAndFound;

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

Route::get('/news/{article}', function (App\Models\NewsArticle $article) {
    return view('article', ['article' => $article]);
})->name('article');

Route::get('/resources', function () {
    return view('resources');
})->name('resources');

Route::get('/forum', function () {
    return view('forum');
})->name('forum');

Route::get('/forum/{post}', function (int $post) {
    return view('forum-post', ['post' => ForumPost::findOrFail($post)]);
})->name('forum.post');

Route::get('/lost-and-found', function () {
    return view('lost-and-found');
})->name('lost-and-found');

Route::get('/lost-and-found/{item}', function (int $item) {
    return view('lost-and-found-detail', ['item' => App\Models\LostAndFound::with('user')->findOrFail($item)]);
})->name('lost-and-found.detail');

Route::get('/boarding-places', function () {
    return view('boarding-places');
})->name('boarding.places');

Route::get('/boarding-places/create', function () {
    return view('boarding-place-create');
})->middleware(['auth', 'verified'])->name('boarding.place.create');

Route::get('/boarding-places/{id}', function ($id) {
    return view('boarding-place-details', ['id' => $id]);
})->name('boarding.place.details');


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

Route::post('/payment/notify', [App\Http\Controllers\PaymentController::class, 'notify'])->name('payment.notify');

Route::get('/payment/success', function () {
    $orderId = request('order_id');
    return view('payment-success', ['orderId' => $orderId]);
})->name('payment.success');

Route::view('/payment/cancel', 'payment-cancel')->name('payment.cancel');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');

    Route::get('/payment/{orderId}', function ($orderId) {
        return view('payment', ['orderId' => $orderId]);
    })->name('payment');

    Route::get('/complaints', function () {
        return view('complaints');
    })->name('complaints');
});

Route::middleware(['admin', 'auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard.home')->name('dashboard');
    Route::view('/dashboard/announcements', 'dashboard.announcements')->name('dashboard.announcements');
    Route::view('/dashboard/merch', 'dashboard.merch')->name('dashboard.merch');
    Route::view('/dashboard/news-articles', 'dashboard.news-articles')->name('dashboard.news-articles');
    Route::view('/dashboard/news-articles/create', 'dashboard.create-article')->name('dashboard.news-articles.create');
    Route::get('/dashboard/news-articles/{article}/edit', function (App\Models\NewsArticle $article) {
        return view('dashboard.edit-article', ['article' => $article]);
    })->name('dashboard.news-articles.edit');
    Route::view('/dashboard/gallery-items', 'dashboard.gallery-items')->name('dashboard.gallery-items');
    Route::view('/dashboard/events', 'dashboard.events')->name('dashboard.events');
    Route::view('/dashboard/complaints', 'dashboard.complaints')->name('dashboard.complaints');
    Route::view('/dashboard/users', 'dashboard.users')->name('dashboard.users');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
