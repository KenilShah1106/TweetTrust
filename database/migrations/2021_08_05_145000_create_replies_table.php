<?php

use App\Constants\TweetConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tweet_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('report_spam_count')->default(0);
            $table->text('body');
            $table->enum('status', TweetConstants::STATUS)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('tweet_id')
                ->references('id')
                ->on('tweets')
                ->onDelete('cascade');

            $table->foreign('parent_id')
                ->references('id')
                ->on('replies')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
