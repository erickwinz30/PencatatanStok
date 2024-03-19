<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Barang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function(Blueprint $table) {
            $table->string('id_barang')->primary();
            $table->string('nama_barang');
            $table->string('supplier_barang');
            $table->integer('berat_barang');
            $table->integer('lead_time');
            $table->integer('demand')->nullable();
            $table->integer('penjualan_tertinggi')->nullable();
            $table->integer('lead_time_terlama');
            $table->integer('jumlah_barang');
            $table->integer('reorder_point')->nullable();
            // $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
