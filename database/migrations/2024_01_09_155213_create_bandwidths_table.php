<?php

use App\Enum\RateUnit;
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
        Schema::create('bandwidths', function (Blueprint $table) {
            $table->id();
            $table->string('name_bw')->unique();
            $table->unsignedInteger('rate_down');
            $table->enum('rate_down_unit', array_column(RateUnit::cases(), 'value'));
            $table->unsignedInteger('rate_up');
            $table->enum('rate_up_unit', array_column(RateUnit::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bandwidths');
    }
};
