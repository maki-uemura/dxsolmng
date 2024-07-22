<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('item_name');
            $table->text('value');
            $table->unsignedBigInteger('search_form_id');
            $table->foreign('search_form_id')->references('id')->on('search_forms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
}