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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id('proyek_id');
            $table->string('proyek_nama');
            $table->string('proyek_pelaksana');
            $table->string('proyek_lokasi');
            $table->string('proyek_pic');
            $table->string('fk_user');
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
        Schema::dropIfExists('proyeks');
    }
};
