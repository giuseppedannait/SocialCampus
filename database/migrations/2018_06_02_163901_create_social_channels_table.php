<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_channels', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('social_id')->unsigned();
                $table->foreign('social_id')->on('socials')->references('id');
            $table->string('name', 128);
            $table->text('description');
            $table->Integer('user_id')->unsigned();
                $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_channels');
    }
}
