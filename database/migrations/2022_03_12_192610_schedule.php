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
        Schema::create("schedules", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->unsignedBigInteger("asset_id");//id of the asset to which the schedule/visit has to do with
            $table->unsignedBigInteger("customer_id");
            $table->foreign('asset_id')->references('id')->on('properties')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade');
            $table->timestamp("due-date");
            $table->enum("status", ['pending', 'acheived'])->default("pending");//pending or echieved
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent();
            $table->boolean("verified")->default(false);//updated by the user(not customer) to true when booking/schedule fee is payed, for a schedule to be treated with priority.
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
