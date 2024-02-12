<?php

use App\Enum\PlanType;
use App\Enum\VoucherStatus;
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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Router::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(PlanType::cases(), 'value'));
            $table->string('code', 55);
            $table->enum('status', array_column(VoucherStatus::cases(), 'value'))->default(VoucherStatus::UNUSED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
