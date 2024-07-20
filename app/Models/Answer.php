<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Answer model represents an answer to a question in the application.
 *
 * This model is used to interact with the 'answers' table in the database. It
 * includes relationships to the User, Question, and Like models.
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'user_id',
        'body',
    ];

    /**
     * Get the user that owns the answer.
     *
     * This defines a relationship where an answer belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that the answer belongs to.
     *
     * This defines a relationship where an answer belongs to a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the likes for the answer.
     *
     * This defines a relationship where an answer can have many likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the upvotes for the answer.
     *
     * This method filters likes to only include upvotes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upvotes()
    {
        return $this->likes()->where('type', true);
    }

    /**
     * Get the downvotes for the answer.
     *
     * This method filters likes to only include downvotes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downvotes()
    {
        return $this->likes()->where('type', false);
    }
}
