<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndpointFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('endpoint_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('endpoint_id')->constrained(); // Foreign key relationship with endpoints table
            $table->json('field_attributes')->nullable();

            // Add other attributes as needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('endpoint_fields');
    }
}
