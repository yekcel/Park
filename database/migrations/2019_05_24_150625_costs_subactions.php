<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CostsSubactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs_subactions', function (Blueprint $table) {
            $table->integer('cost_id')->unsigned()->index();
            $table->foreign('cost_id')->references('id')->on('costs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('subaction_id')->unsigned()->index();
            $table->foreign('subaction_id')->references('id')->on('subactions')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs_subactions');
    }
}
