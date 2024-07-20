<?php
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', [TopicController::class, 'index'])->name('index');
Route::get('/questions/{topicName}', [QuestionController::class, 'showQuestionsByTopic'])->name('questions.index');
Route::get('/createQuestion', [QuestionController::class, 'showQuestionCreationForm'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'createNewQuestion'])->name('questions.store');
Route::get('/questions/{topicName}/{questionId}', [QuestionController::class, 'show'])->name('questions.show');

// Admin-specific routes (authenticated and admin users)
Route::middleware([UserMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::get('/editTopicForm/{id}', [TopicController::class, 'showEditTopicForm'])->name('topics.showEditTopicForm');
    Route::put('/editTopic/{id}', [TopicController::class, 'editTopic'])->name('topics.editTopic');
    Route::post('/createTopic', [TopicController::class, 'createTopic'])->name('topics.createTopic');
    Route::delete('/deleteTopic/{id}', [TopicController::class, 'deleteTopic'])->name('topics.delete');
    Route::get('/showCreateForm', [TopicController::class, 'showCreateForm'])->name('topics.showCreateForm');
    
    Route::get('/listUsers', [UserController::class, 'listUsers'])->name('users.list');
    Route::delete('/deleteUser/{userId}', [UserController::class, 'deleteUser'])->name('users.delete');
});

// Guest-specific routes
Route::middleware('guest')->group(function () {
    Route::get('/registration', [RegistrationController::class, 'showRegistrationForm'])->name('registration.form');
    Route::post('/signUp', [RegistrationController::class, 'signUp'])->name('signUp');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

// Authenticated user routes
Route::middleware(UserMiddleware::class)->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Routes for questions
    Route::delete('/deleteQuestion/{questionId}', [QuestionController::class,'deleteQuestion'])->name('questions.delete');
    Route::delete('/deleteQuestionFromProfile/{questionId}', [QuestionController::class,'deleteFromProfile'])->name('questions.deleteFromProfile');

    // Routes for answers
    Route::post('/createAnswer', [AnswerController::class,'createAnswer'])->name('answers.create');
    Route::delete('/deleteAnswer/{answerId}', [AnswerController::class,'deleteAnswer'])->name('answers.delete');

    // Routes for user profiles and management
    Route::get('/profile/{userId}', [UserController::class, 'index'])->name('users.profile');
    Route::get('/EditUserForm/{userId}', [UserController::class, 'showEditUserForm'])->name('users.showEditUserForm');
    Route::put('/EditUser/{userId}', [UserController::class, 'editUser'])->name('users.editUser');

    // Route for liking/voting
    Route::post('vote/{answerId}', [LikeController::class,'vote'])->name('likes.vote');
});
