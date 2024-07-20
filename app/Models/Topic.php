<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Topic model represents a topic in the application.
 *
 * This model is used to interact with the 'topics' table in the database.
 * It includes a relationship to the Question model.
 */
class Topic extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_visible',
    ];

    /**
     * Get the questions for the topic.
     *
     * This defines a relationship where a topic can have many questions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
