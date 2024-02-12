<?php

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
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
        Schema::create('user_recharges', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Router::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Plan::class)->constrained()->cascadeOnDelete();
            $table->string('username', 32);
            $table->string('namebp', 40);
            $table->dateTime('recharged_at');
            $table->dateTime('expired_at');
            $table->string('status', 20);
            $table->string('method', 128)->default('');
            $table->string('type', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_recharges');
    }
};
