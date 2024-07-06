<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToLikesTable extends Migration
{
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->boolean('type')->nullable()->after('user_id');
        });
        DB::table('likes')->update(['type' => true]); 

        Schema::table('likes', function (Blueprint $table) {
            $table->boolean('type')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
