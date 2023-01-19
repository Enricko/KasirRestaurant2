<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('pesanans', function (Blueprint $table) {
        //     $table->id('id_pesanan');
        //     $table->date('tgl_pesanan');
        //     $table->unsignedBigInteger('id');
        //     $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        //     $table->unsignedBigInteger('no_meja');
        //     $table->foreign('no_meja')->references('no_meja')->on('mejas')->onDelete('cascade');
        //     $table->bigInteger('total_harga');
        //     $table->bigInteger('bayar');
        //     $table->bigInteger('kembali');
        //     $table->enum('status_pesanan',['0','1']);
        //     $table->enum('status_makanan_pesanan',['sedang diproses','siap antar','telah disaji']);
        //     $table->timestamps();
        // });
        DB::unprepared("
        CREATE TRIGGER pesanan_total_insert AFTER INSERT ON detail_pesanans FOR EACH ROW
            BEGIN
                UPDATE pesanans SET total_harga = total_harga + new.sub_total
                WHERE id_pesanan = new.id_pesanan;
            END
        ");
        DB::unprepared("
        CREATE TRIGGER pesanan_total_update AFTER UPDATE ON detail_pesanans FOR EACH ROW
            BEGIN
                UPDATE pesanans SET total_harga = total_harga + (new.sub_total - old.sub_total)
                WHERE id_pesanan = new.id_pesanan;
            END
        ");
        DB::unprepared("
        CREATE TRIGGER pesanan_total_delete AFTER DELETE ON detail_pesanans FOR EACH ROW
            BEGIN
                UPDATE pesanans SET total_harga = total_harga - old.sub_total
                WHERE id_pesanan = old.id_pesanan;
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');

        DB::unprepared('DROP TRIGGER `pesanan_total_insert`');
        DB::unprepared('DROP TRIGGER `pesanan_total_update`');
        DB::unprepared('DROP TRIGGER `pesanan_total_delete`');
    }
};
