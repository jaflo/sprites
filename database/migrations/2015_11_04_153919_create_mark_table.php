<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("marked", function(Blueprint $table)
		{
			$table->increments("id");
			$table->string("username");
			$table->string("alphaid", 10)->index();
			$table->string("collection", 10)->index();
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
		Schema::drop("marked");
    }
}
