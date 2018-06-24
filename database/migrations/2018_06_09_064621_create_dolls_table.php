<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dolls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->string('priority')->nullable();
            $table->integer('stock')->nullable()->default(0);
            $table->integer('ideal')->nullable()->default(0);
            $table->string('price')->nullable();
            $table->string('rank')->nullable();
            $table->text('notes')->nullable();
            $table->integer('etsy_id')->nullable()->index();
        });

        Schema::create('links', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('doll_id')->unsigned();
            $table->string('label')->nullable();
            $table->string('url');

            $table->foreign('doll_id')
                ->references('id')
                ->on('dolls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function(Blueprint $table) {
            $table->dropForeign(['doll_id']);
        });

        Schema::dropIfExists('dolls');
        Schema::dropIfExists('links');
    }
}
