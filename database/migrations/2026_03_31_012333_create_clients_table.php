<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->integer('client_id')->autoIncrement();
            $table->string('first_name', 45);
            $table->string('middle_name', 45); 
            $table->string('last_name', 45 ); 
            $table->string('email', 45) ->unique();
            $table->string('phone', 45);
            $table->string('passport', 45);
            $table->char('data_country_code', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
