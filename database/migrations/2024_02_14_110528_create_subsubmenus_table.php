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
        Schema::create('subsubmenus', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('nama_subsubmenu');
            $table->string('tautan_subsubmenu')->nullable();
            $table->integer('urutan_subsubmenu')->default(0);
            $table->uuid('submenu_id');
            $table->foreign('submenu_id')->references('id')->on('submenus')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsubmenus');
    }
};
