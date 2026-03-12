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
        Schema::create('foto', function (Blueprint $table) {
        $table->id('FotoID');
        $table->string('JudulFoto', 255);
        $table->text('DeskripsiFoto');
        $table->date('TanggalUnggah');
        $table->string('LokasiFile', 255);
        $table->foreignId('AlbumID')->constrained('album', 'AlbumID')->onDelete('cascade');
        $table->foreignId('UserID')->constrained('user', 'UserID')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
