<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('peminjaman_users', function (Blueprint $table) {
        $table->date('tanggal_pengembalian')->nullable()->after('tanggal_peminjaman');
    });
}

public function down()
{
    Schema::table('peminjaman_users', function (Blueprint $table) {
        $table->dropColumn('tanggal_pengembalian');
    });
}

};
