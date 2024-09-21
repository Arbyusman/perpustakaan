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
        Schema::create('menu_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('create');
            $table->integer('read');
            $table->integer('update');
            $table->integer('delete');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("menu_id")->references('id')->on("menus")->onDelete('cascade');
            $table->foreign("role_id")->references('id')->on("roles")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_accesses');
    }
};
