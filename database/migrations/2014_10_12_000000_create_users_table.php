<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 255);
            $table->string("username", 255)->unique()->index();
			$table->string("alphaid", 10)->unique()->index();
            $table->string("password", 60);
            $table->string("about", 2000);
            $table->string("rights", 255)->index();
            $table->rememberToken();
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
        Schema::drop("users");
    }
}
