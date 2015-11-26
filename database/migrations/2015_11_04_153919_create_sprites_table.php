<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sprites", function(Blueprint $table)
		{
			$table->increments("id");
			$table->string("username", 255)->index();
			$table->string("title", 200);
			$table->string("description", 2000);
			$table->string("alphaid", 10)->unique()->index();
			$table->string("license", 10)->index();
			$table->integer("favorites")->default(0)->unsigned();
			$table->string("colors", 255);
			$table->integer("width")->unsigned();
			$table->integer("height")->unsigned();
			$table->integer("filesize")->unsigned();
			$table->string("checkfile", 255)->index();
			$table->timestamps();
		});
		DB::statement("ALTER TABLE sprites ADD FULLTEXT search(title,description,colors)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("sprites", function($table) {
			$table->dropIndex("search");
		});
		Schema::drop("sprites");
    }
}
