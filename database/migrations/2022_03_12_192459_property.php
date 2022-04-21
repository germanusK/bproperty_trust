<?php

use App\Models\AssetCategory;
use App\Models\AssetGrade;
use App\Models\AssetGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Isset_;
use SebastianBergmann\Environment\Console;

class Property extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        

        //
        Schema::create("properties", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->string("name");
            $table->string("description")->nullable(); //concise description of the item e.g house properties and facilities.
            $table->json("images");//will have to store >=1 image of the item
            $table->unsignedBigInteger("category"); //say electronics, cloth, wearables, house|land|etc
            $table->foreign('category')->references('id')->on('asset_categories')->onUpdate('cascade');
            $table->unsignedBigInteger("grade");//give the item a grade that boosts its priority to be presented on site.
            $table->foreign('grade')->references('id')->on('asset_grades')->onUpdate('cascade');
            $table->string("price");//price per item.
            $table->timestamp("created_at")->useCurrent();//time stamp on which the asset was uplaoded
            $table->timestamp("updated_at")->useCurrent();
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
        Schema::dropIfExists("property");
    }
}
