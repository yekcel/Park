<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActassignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actassigns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('comments');
            $table->integer('source_id')->unsigned()->index();
            $table->foreign('source_id')->references('code')->on('sources');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

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
        Schema::dropIfExists('actassigns');
    }
}
