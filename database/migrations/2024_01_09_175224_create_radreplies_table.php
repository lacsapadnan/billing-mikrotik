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
        Schema::create('radreplies', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->default('')->index();
            $table->string('attribute', 64)->default('');
            $table->string('op', 2)->default('==');
            $table->string('value', 253)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radreplies');
    }
};
