<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenSecretToSocialChannel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_channels', function (Blueprint $table) {
            $table->string('access_token_secret')->after('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_channels', function (Blueprint $table) {
            $table->dropColumn('access_token_secret');
        });
    }
}
