<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function(Blueprint $tabale){
            $tabale->foreign("post_id")->references('id')->on('posts');
            $tabale->foreign("user_id")->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function(Blueprint $tabale){
            $tabale->dropForeign("comments_post_id_foreign");
            $tabale->dropForeign("comments_user_id_foreign");
        });
    }
}
