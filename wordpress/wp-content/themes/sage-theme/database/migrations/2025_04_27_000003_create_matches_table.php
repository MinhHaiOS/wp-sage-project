<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('competition_id')
                  ->constrained('leagues')
                  ->onDelete('cascade');
            $table->foreignUuid('home_team_id')
                  ->constrained('teams')
                  ->onDelete('cascade');
            $table->foreignUuid('away_team_id')
                  ->constrained('teams')
                  ->onDelete('cascade');

            $table->tinyInteger('status_id')->unsigned();

            $table->unsignedBigInteger('match_start_time');
            $table->unsignedSmallInteger('match_time')->nullable();


            $table->string('home_scores');
            $table->string('away_scores');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
