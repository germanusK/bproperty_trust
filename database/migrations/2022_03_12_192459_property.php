<?php

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

        $images = DB::table('property')->get('images');
        

        //
        Schema::create("property", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->string("name");
            $table->enum("group", ["RE", "GC"]);//whether real estate or general commerce item
            $table->string("category"); //say electronics, cloth, wearables, house|land|etc
            $table->string("description")->nullable(); //concise description of the item e.g house properties and facilities.
            $table->text("images");//will have to store >=1 image of the item
            $table->string("grade");//give the item a grade that boosts its priority to be presented on site.
            $table->string("price");//price per item.
            $table->timestamp("created_at")->useCurrent();//time stamp on which the asset was uplaoded
            $table->timestamp("updated_at")->useCurrent();
        });

        if( is_countable($images))
        foreach ($images as $key => $value) {
            # code...
            $value = json_decode($value);
            foreach ($value as $key => $value1) {
                # code...
                Storage::delete($value1);
            }
        }
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
