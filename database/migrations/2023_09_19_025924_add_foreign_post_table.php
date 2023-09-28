<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function(Blueprint $tabale){
            $tabale->foreign("user_id")->references('id')->on('users');
            $tabale->foreign("category_id")->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function(Blueprint $tabale){
            $tabale->dropForeign("posts_user_id_foreign");
            $tabale->dropForeign("posts_category_id_foreign");
        });
    }
}
