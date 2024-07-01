<?php
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/topics', [TopicController::class, 'index']);