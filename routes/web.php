<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/logout', function () {
    return view('pages.authentication.sign-in');
});
