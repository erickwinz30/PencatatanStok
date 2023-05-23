<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModelLog extends Model {
    public function readLogMasuk() {
        $log = DB::table('log_barang')->where('status_barang', 'Baru')->orWhere('status_barang', 'Retur')->orderBy('tanggal_log', 'desc')->get();
        return $log;
    }

    public function readLogKeluar() {
        $log = DB::table('log_barang')->where('status_barang', 'Terjual')->orWhere('status_barang', 'Cabang')->orderBy('tanggal_log', 'desc')->get();
        return $log;
    }

    public function simpanLogBaru($x) {
        $currentDate = Carbon::now('Asia/Jakarta');

        $barang = DB::table('log_barang')->insert([
            'id_barang'=>$x->id_barang,
            'jumlah_barang'=>$x->jumlah_barang,
            'status_barang'=>'Baru',
            'tanggal_log' => $currentDate,
            'keterangan'=>$x->keterangan,
        ]);
    }
}