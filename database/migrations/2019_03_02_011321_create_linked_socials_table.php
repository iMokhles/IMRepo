<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_socials', function (Blueprint $table) {
            $table->increments('id');

            $table->string('provider_id');
            $table->string('provider');

            $table->morphs('model');

            $table->text('token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->text('token_secret')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('nickname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();

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
        Schema::dropIfExists('linked_socials');
    }
}
