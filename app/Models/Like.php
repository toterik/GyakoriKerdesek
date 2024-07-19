<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'answer_id',
        'user_id',
        'type',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
