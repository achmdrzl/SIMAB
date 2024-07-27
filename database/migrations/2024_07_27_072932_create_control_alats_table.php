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
        Schema::create('control_alats', function (Blueprint $table) {
            $table->id('controlAlat_id');
            $table->bigInteger('alat_id')->unsigned()->nullable();
            $table->foreign('alat_id')->references('alat_id')->on('alats')->onDelete('cascade');
            $table->string('alat_kondisi')->nullable();
            $table->integer('alat_jml')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_alats');
    }
};
