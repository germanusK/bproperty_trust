<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("schedule", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->unsignedBigInteger("asset_id");//id of the asset to which the schedule/visit has to do with
            $table->timestamp("due-date")->useCurrent();
            $table->unsignedBigInteger("customer_id");
            $table->string("status")->default("pending");//pending or echieved
            $table->timestamp("creation_time")->useCurrent();
            $table->timestamp("last_update_time")->useCurrent();
            $table->boolean("validated")->default(false);//updated by the user(not customer) to true when booking/schedule fee is payed, for a schedule to be treated with priority.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("schedule");
    }
}
