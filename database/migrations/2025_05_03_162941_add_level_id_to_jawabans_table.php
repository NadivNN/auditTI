<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelIdToJawabansTable extends Migration
{
    /**
     * Jalankan migration untuk menambahkan kolom level_id.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jawabans', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->after('quisioner_id');  // Menambahkan level_id
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');  // Menambahkan foreign key
        });
    }

    /**
     * Rollback migration jika diperlukan.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jawabans', function (Blueprint $table) {
            $table->dropForeign(['level_id']);  // Menghapus foreign key
            $table->dropColumn('level_id');  // Menghapus kolom level_id
        });
    }
}
