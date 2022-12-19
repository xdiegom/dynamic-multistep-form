<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_fields_validations', function (Blueprint $table) {
            $table->id();
            $table->string('input_name')->comment('The input that will be validated');
            $table->unsignedBigInteger('parent_input_id')
                  ->nullable()
                  ->comment('Indicates if the input is part of a JSON or array');
            $table->string('request_key')->comment('Indicates the first level key of the request in which input fields belongs to');
            $table->string('rules')->comment('Laravel rules that will validate the input value separated by \'|\'');

            $table->foreign('parent_input_id')->references('id')->on('input_fields_validations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_fields_validations');
    }
};
