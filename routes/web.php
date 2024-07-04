<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TopicController::class, 'index'])->name('index');

Route::get('/registration', [RegistrationController::class, 'showRegistrationForm'])->name('registration.form');
Route::post('/signUp', [RegistrationController::class, 'signUp'])->name('signUp');;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/questions/{topicName}', [QuestionController::class, 'showQuestionsByTopic'])->name('questions.index');
Route::get('/create', [QuestionController::class, 'showQuestionCreationForm'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'createNewQuestion'])->name('questions.store');
Route::get('/questions/{topicName}/{questionId}', [QuestionController::class, 'show'])->name('questions.show');
