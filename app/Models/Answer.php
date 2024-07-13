<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'user_id',
        'body'
     ];
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     public function question()
     {
         return $this->belongsTo(Question::class);
     }
     public function likes()
     {
        return $this->hasMany(Like::class);
     }

     public function upvotes()
     {
         return $this->likes()->where('type', true);
     }
 
     public function downvotes()
     {
         return $this->likes()->where('type', false);
     }
}

