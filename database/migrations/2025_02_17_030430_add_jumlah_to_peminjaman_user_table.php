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
    Schema::table('peminjaman_users', function (Blueprint $table) {
        $table->integer('jumlah')->default(1); // Default 1 untuk jumlah barang yang dipinjam
    });
}

public function down()
{
    Schema::table('peminjaman_users', function (Blueprint $table) {
        $table->dropColumn('jumlah');
    });
}

};
