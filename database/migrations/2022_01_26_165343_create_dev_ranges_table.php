<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_ranges', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('age_range_id')->constrained();
            $table->unsignedInteger('min_rating');
            $table->unsignedInteger('max_rating');
            $table->integer('min_dev');
            $table->integer('max_dev');
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
        Schema::dropIfExists('dev_ranges');
    }
}
