<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportnotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportnotifications', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id');
            $table->string('name');
            $table->string('reportingtime');
            $table->string('timereported');
            $table->integer('timediff');
            $table->integer('status');
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
        Schema::dropIfExists('reportnotifications');
    }
}
