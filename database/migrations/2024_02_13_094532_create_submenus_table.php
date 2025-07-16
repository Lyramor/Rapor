<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submenus', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('nama_submenu');
            $table->string('tautan_submenu')->nullable();
            $table->integer('urutan_submenu')->default(0);
            $table->uuid('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenus');
    }
};
