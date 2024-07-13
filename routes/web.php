<?php
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TopicController::class, 'index'])->name('index');
Route::post('/editTopicForm/{id}', [TopicController::class, 'showEditTopicForm'])->name('topics.showEditTopicForm');
Route::post('/editTopic/{id}', [TopicController::class, 'editTopic'])->name('topics.editTopic');
Route::post('/createTopic', [TopicController::class, 'createTopic'])->name('topics.createTopic');
Route::post('/deleteTopic/{id}', [TopicController::class, 'deleteTopic'])->name('topics.delete');
Route::get('/showCreateForm', [TopicController::class, 'showCreateForm'])->name('topics.showCreateForm');

Route::get('/registration', [RegistrationController::class, 'showRegistrationForm'])->name('registration.form');
Route::post('/signUp', [RegistrationController::class, 'signUp'])->name('signUp');;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/questions/{topicName}', [QuestionController::class, 'showQuestionsByTopic'])->name('questions.index');
Route::get('/createQuestion', [QuestionController::class, 'showQuestionCreationForm'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'createNewQuestion'])->name('questions.store');
Route::get('/questions/{topicName}/{questionId}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/deleteQuestion/{questionId}', [QuestionController::class,'deleteQuestion'])->name('questions.delete');
Route::post('/deleteQuestionFromProfile/{questionId}', [QuestionController::class,'deleteFromProfile'])->name('questions.deleteFromProfile');

Route::post('/createAnswer', [AnswerController::class,'createAnswer'])->name('answers.create');
Route::post('/deleteAnswer/{answerId}', [AnswerController::class,'deleteAnswer'])->name('answers.delete');

Route::get('/profile/{userId}', [UserController::class, 'index'])->name('users.profile');
Route::get('/listUsers', [UserController::class, 'listUsers'])->name('users.list');
Route::post('/deleteUser/{userId}', [UserController::class, 'deleteUser'])->name('users.delete');
Route::get('/EditUserForm/{userId}', [UserController::class, 'showEditUserForm'])->name('users.showEditUserForm');
Route::put('/EditUser/{userId}', [UserController::class, 'editUser'])->name('users.editUser');
