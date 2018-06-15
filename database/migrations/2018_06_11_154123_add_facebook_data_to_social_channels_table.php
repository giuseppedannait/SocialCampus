<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacebookDataToSocialChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_channels', function (Blueprint $table) {
            $table->string('access_token')->after('description');
            $table->string('category')->after('description');
            $table->renameColumn('description', 'type');
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
            $table->dropColumn('access_token', 'category');
            $table->renameColumn('type', 'description');
        });
    }
}