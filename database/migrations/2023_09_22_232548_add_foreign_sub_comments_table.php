<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignSubCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("sub_comments", function(Blueprint $table) {
            $table->foreign("comment_id")->references("id")->on("comments");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("sub_comments", function(Blueprint $table) {
            $table->dropForeign("sub_comments_comment_id_foreign");
            $table->dropForeign("sub_comments_user_id_foreign");
        });
    }
}
