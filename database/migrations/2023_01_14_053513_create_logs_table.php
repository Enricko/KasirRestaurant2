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
        // Schema::create('logs', function (Blueprint $table) {
        //     $table->id('id_log');
        //     $table->text('deskripsi');
        //     $table->timestamps();
        // });
        // // === MEJA ===
        // DB::unprepared("
        // CREATE TRIGGER log_insert_meja AFTER INSERT ON mejas FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT('Meja telah di tambah dari data meja',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_update_meja AFTER UPDATE ON mejas FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT('Meja telah di update dari data meja',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_delete_meja AFTER DELETE ON mejas FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT('Meja telah di hapus dari data meja',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        DB::unprepared("
        CREATE TRIGGER log_status_meja AFTER UPDATE ON mejas FOR EACH ROW
        BEGIN
            DECLARE text_ text(500);
            SET text_ = CONCAT('Meja No.',old.no_meja,' status berubah menjadi ',new.status_meja,' | ',now());
            INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        END
        ");
        // // === MEJA ===

        // // === USER ===
        // DB::unprepared("
        // CREATE TRIGGER log_insert_user AFTER INSERT ON users FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(new.name,'_',new.level,' telah di tambahkan data user',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_update_user AFTER UPDATE ON users FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(old.name,'_',old.level,' telah di update dari data user menjadi ',new.name,'_',new.level,' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_delete_user AFTER DELETE ON users FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(old.name,'_',old.level,' telah di hapus dari data user',' | ',now());
        //     INSERT INTO log_triggers VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // // === USER ===

        // // === MASAKAN ===
        // DB::unprepared("
        // CREATE TRIGGER log_insert_masakan AFTER INSERT ON masakans FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(new.nama_masakan,'_',new.type,'_',new.harga,' telah di tambah dari data masakan',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_update_masakan AFTER UPDATE ON masakans FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(old.nama_masakan,'_',old.type,'_',old.harga,' telah di update dari data masakan menjadi ',new.nama_masakan,'_',new.type,'_',new.harga,' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_delete_masakan AFTER DELETE ON masakans FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(old.nama_masakan,'_',old.type,'_',old.harga,' telah di hapus dari data masakan',' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");
        // DB::unprepared("
        // CREATE TRIGGER log_persedian_masakan AFTER UPDATE ON masakans FOR EACH ROW
        // BEGIN
        //     DECLARE text_ text(500);
        //     SET text_ = CONCAT(old.nama_masakan,' persedian',new.status_masakan,' | ',now());
        //     INSERT INTO logs VALUES (NULL,text_,now(),NULL);
        // END
        // ");

        // // === MASAKAN ===
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');

        // === Meja ===
        DB::unprepared('DROP TRIGGER `log_insert_meja`');
        DB::unprepared('DROP TRIGGER `log_update_meja`');
        DB::unprepared('DROP TRIGGER `log_delete_meja`');
        // === Meja ===
        // === USER ===
        DB::unprepared('DROP TRIGGER `log_insert_user`');
        DB::unprepared('DROP TRIGGER `log_update_user`');
        DB::unprepared('DROP TRIGGER `log_delete_user`');
        // === USER ===
        // === MASAKAN ===
        DB::unprepared('DROP TRIGGER `log_insert_masakan`');
        DB::unprepared('DROP TRIGGER `log_update_masakan`');
        DB::unprepared('DROP TRIGGER `log_delete_masakan`');
        // === MASAKAN ===
    }
};
