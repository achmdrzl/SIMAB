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
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->id('suratjalan_id');
            $table->integer('proyek_id')->nullable();
            $table->date('suratjalan_tgl');
            $table->string('suratjalan_driver');
            $table->string('suratjalan_pengawaslapangan');
            $table->integer('suratjalan_jmlalat')->nullable();
            $table->enum('status', ['selesai', 'on-progress'])->default('on-progress');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalans');
    }
};
