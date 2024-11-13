<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_imports', function (Blueprint $table) {
            $table->id();
            $table->string('excel_class');
            $table->string('path');
            $table->string('storage_disk')->nullable();
            $table->dateTime('imported_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->json('errors')->nullable();
            $table->json('messages')->nullable();
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
        Schema::dropIfExists('excel_imports');
    }
};
