<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TopicController::class, 'index'])->name('topics.index');

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
Route::post('/signUp', [RegistrationController::class, 'signUp'])->name('signUp');;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/questions/{topicId}', [QuestionController::class, 'showQuestionsByTopic'])->name('showQuestions');
Route::get('/newQuestionShow', [QuestionController::class, 'newQuestionShow'])->name('newQuestionShow');
Route::post('/newQuestion', [QuestionController::class, 'newQuestion'])->name('newQuestion');
