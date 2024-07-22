<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('error_messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('message');
            $table->unsignedBigInteger('form_field_id');
            $table->foreign('form_field_id')->references('id')->on('form_fields');
        });
    }

    public function down()
    {
        Schema::dropIfExists('error_messages');
    }
}