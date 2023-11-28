<?php

// database/migrations/xxxx_xx_xx_create_field_values_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldValuesTable extends Migration
{
    public function up()
    {
        Schema::create('field_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->text('value');
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('endpoint_fields')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('field_values');
    }
}
