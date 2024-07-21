<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

/**
 * User model represents a user in the application.
 *
 * This model is used to interact with the 'users' table in the database.
 * It includes relationships to the Answer and Question models.
 * Implements MustVerifyEmail and CanResetPasswordInterface for email verification and password reset functionality.
 */
class User extends Authenticatable implements MustVerifyEmail, CanResetPasswordInterface
{
    use Notifiable, CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_admin',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected function casts() {
        return ['email_verified_at' => 'datetime',];
    }

    /**
     * Get the answers for the user.
     *
     * This defines a relationship where a user can have many answers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the questions for the user.
     *
     * This defines a relationship where a user can have many questions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the likes of the user.
     *
     * This defines a relationship where a user can have many likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
