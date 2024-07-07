<?php
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TopicController::class, 'index'])->name('index');
Route::post('/setTopicVisibility/{id}', [TopicController::class, 'setTopicVisibility'])->name('topic.setVisibilty');


Route::get('/registration', [RegistrationController::class, 'showRegistrationForm'])->name('registration.form');
Route::post('/signUp', [RegistrationController::class, 'signUp'])->name('signUp');;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/questions/{topicName}', [QuestionController::class, 'showQuestionsByTopic'])->name('questions.index');
Route::get('/createQuestion', [QuestionController::class, 'showQuestionCreationForm'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'createNewQuestion'])->name('questions.store');
Route::get('/questions/{topicName}/{questionId}', [QuestionController::class, 'show'])->name('questions.show');

Route::post('/createAnswer', [AnswerController::class,'createAnswer'])->name('answers.create');
Route::post('/deleteAnswer/{answerId}', [AnswerController::class,'deleteAnswer'])->name('answers.delete');
