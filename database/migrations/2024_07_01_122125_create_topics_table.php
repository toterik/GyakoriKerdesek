<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    public function up()
    {
        Schema::create('topics', function (Blueprint $table)
         {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('topics');
    }
}