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
        Schema::create('surat_jalan_details', function (Blueprint $table) {
            $table->id('detailsuratjalan_id');
            $table->integer('suratjalan_id')->nullable();
            $table->integer('alat_id')->nullable();
            $table->string('alat_platno')->nullable();
            $table->string('alat_jenis')->nullable();
            $table->integer('alat_jml')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan_details');
    }
};
