<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DivisionSettingsController;
use App\Http\Controllers\OrganizationMemberController;
use App\Http\Controllers\OrganizationPageController;
use App\Http\Controllers\OrganizationSettingsController;
use App\Http\Controllers\OrganizationUserController;
use App\Http\Controllers\TransactionDivisionController;
use App\Http\Controllers\TransactionOrganizationController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;   

// dashboard pages
Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Organizations
Route::resource('organizations', OrganizationPageController::class)->middleware('auth');

// Organisasi buat Divisi
Route::resource('organizations.divisions',DivisionController::class);

// Divisi
Route::resource('divisions', DivisionController::class);

// Transaksi
Route::resource('organizations.transactions', TransactionOrganizationController::class);
Route::resource('divisions.transactions', TransactionDivisionController::class);

// Join Organization
Route::resource('organization.memberJoin', OrganizationMemberController::class)->middleware('auth');

// Settings
// Setting Organizations
Route::get(
    '/organizations/{organization}/settings',
    [OrganizationSettingsController::class, 'index']
)->name('organizations.settings');

// Settings divisions
Route::get(
    '/divisions/{division}/settings',
    [DivisionSettingsController::class, 'index']
)->name('divisions.settings');

// Member 
// Member Organisasi
Route::resource('organization.users', OrganizationUserController::class);



// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', [AuthController::class, 'me'])->middleware('auth')->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');


// authentication pages
Route::get('/login', function () {
    return view('pages.auth.login', ['title' => 'Sign In']);
})->name('login');

Route::get('/register', function () {
    return view('pages.auth.register', ['title' => 'Sign Up']);
})->name('signup');

// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');


Route::fallback(function () {
    return response()->view('pages.errors.error-404', [], 404);
});





















