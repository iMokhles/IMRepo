<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depictions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')
                ->references('id')->on('packages')
                ->onDelete('cascade');
            $table->longText('long_description')->nullable();
            $table->enum('mini_ios', \App\Enums\DepictionVersions::getValues())
                ->default(\App\Enums\DepictionVersions::IOS_9);
            $table->enum('max_ios', \App\Enums\DepictionVersions::getValues())
                ->default(\App\Enums\DepictionVersions::IOS_12_1);
            $table->string('price')->nullable();
            $table->enum('devices_support', \App\Enums\DepictionDevices::getValues())
                ->default(\App\Enums\DepictionDevices::ALL);
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
        Schema::dropIfExists('depictions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
