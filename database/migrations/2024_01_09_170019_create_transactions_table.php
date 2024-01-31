<?php

use App\Enum\PlanType;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 25);
            $table->string('username', 32);
            $table->string('plan_name', 40);
            $table->string('price', 40);
            $table->dateTime('recharged_at');
            $table->dateTime('expired_at');
            $table->string('method', 128);
            $table->string('routers', 32);
            $table->enum('type', array_column(PlanType::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
