<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('barang', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang'); 
        $table->string('kategori')->default('lainnya'); // Perbaiki disini
        $table->integer('jumlah_stok')->default(0);
        $table->string('status')->default('tersedia');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
