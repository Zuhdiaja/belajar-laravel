<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_siswa', function (Blueprint $table) {
            $table->id();
            $table->string("nama_siswa");
            $table->string("tanggal_lahir");
            $table->enum("gender" , ["L" , "P"]);
            $table->string("gambar");
            $table->string("alamat");
            $table->timestamps();
            // 'nama_siswa','tanggal_lahir','gender','gambar','alamat'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_siswa');
    }
};
