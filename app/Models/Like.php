<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Like model represents a like or vote on an answer in the application.
 *
 * This model is used to interact with the 'likes' table in the database. It
 * includes relationships to the Answer model.
 */
class Like extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer_id',
        'user_id',
        'type',
    ];

    /**
     * Get the answer that this like belongs to.
     *
     * This defines a relationship where a like belongs to an answer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
