<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');


            // reviewed package
            $table->morphs('package');

            // author of review
            $table->morphs('author');

            // reviewed version
            $table->string('package_version');

            // review text
            $table->longText('comment');

            // NestedSet
            $table->unsignedInteger('parent_id')->nullable();

            // admin
            $table->boolean('approved')->default(false);

            // review rate
            $table->double('rate', 15, 8)->nullable();

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
        Schema::dropIfExists('reviews');
    }
}
