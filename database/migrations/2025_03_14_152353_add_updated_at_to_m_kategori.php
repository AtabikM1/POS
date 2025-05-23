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
    Schema::table('m_kategori', function (Blueprint $table) {
        $table->timestamp('updated_at')->nullable(); // Menambahkan kolom 'updated_at'
    });
}

public function down()
{
    Schema::table('m_kategori', function (Blueprint $table) {
        $table->dropColumn('updated_at'); // Menghapus kolom 'updated_at'
    });
}

};
