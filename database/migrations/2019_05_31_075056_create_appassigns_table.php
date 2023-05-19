<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppassignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appassigns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('comments');
            $table->integer('source_id')->unsigned()->index();
            $table->foreign('source_id')->references('code')->on('sources');
            $table->integer('application_id')->unsigned();
            $table->foreign('application_id')->references('id')->on('applications');
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
        Schema::dropIfExists('appassigns');
    }
}
