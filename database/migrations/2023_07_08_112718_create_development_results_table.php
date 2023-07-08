<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('development_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('development_round_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('series_id')->nullable()->constrained();
            $table->unsignedInteger('rating');
            $table->integer('dev');
            $table->unsignedInteger('new_rating');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_results');
    }
};
