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
       Schema::create('likefoto', function (Blueprint $table) {
        $table->id('LikeID');
        $table->foreignId('FotoID')->constrained('foto', 'FotoID')->onDelete('cascade');
        $table->foreignId('UserID')->constrained('user', 'UserID')->onDelete('cascade');
        $table->date('TanggalLike');
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
