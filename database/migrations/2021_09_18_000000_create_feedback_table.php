<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('email', 32)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('first_name', 15)->nullable();
            $table->string('last_name', 20)->nullable();
            $table->string('middle_name', 64)->nullable();
            $table->string('message', 200);
            $table->boolean('anonymous');
            $table->timestamps();
            $table->unique(['email']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
