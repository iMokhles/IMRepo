<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_logs', function (Blueprint $table) {
            $table->increments('id');

            // log's package
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')
                ->references('id')->on('packages')
                ->onDelete('cascade');
            // moderator of change log
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            // change log text
            $table->text('changes')->nullable();
            // package version
            $table->string('package_version')->nullable();
            // package hash
            $table->string('package_hash')->nullable();
            // package identifier
            $table->string('package_identifier')->nullable();

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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('change_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
