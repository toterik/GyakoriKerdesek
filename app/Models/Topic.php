<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    // Ensure the model knows which table to use (if it's not following Laravel's naming conventions)
    protected $table = 'topics';
}
