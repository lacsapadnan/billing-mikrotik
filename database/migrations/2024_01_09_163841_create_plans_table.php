<?php

use App\Enum\DataUnit;
use App\Enum\LimitType;
use App\Enum\PlanType;
use App\Enum\PlanTypeBp;
use App\Enum\TimeUnit;
use App\Enum\ValidityUnit;
use App\Models\Bandwidth;
use App\Models\Pool;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Bandwidth::class)->constrained();
            $table->foreignIdFor(Router::class)->nullable()->constrained();
            $table->foreignIdFor(Pool::class, 'pool_id')->nullable()->constrained();
            $table->foreignIdFor(Pool::class, 'pool_expired_id')->nullable()->constrained('pools');
            $table->string('price', 40);
            $table->enum('type', array_column(PlanType::cases(), 'value'));
            $table->enum('typebp', array_column(PlanTypeBp::cases(), 'value'))->nullable();
            $table->enum('limit_type', array_column(LimitType::cases(), 'value'))->nullable();
            $table->unsignedInteger('time_limit')->nullable();
            $table->enum('time_unit', array_column(TimeUnit::cases(), 'value'))->nullable();
            $table->unsignedInteger('data_limit')->nullable();
            $table->enum('data_unit', array_column(DataUnit::cases(), 'value'))->nullable();
            $table->integer('validity');
            $table->enum('validity_unit', array_column(ValidityUnit::cases(), 'value'));
            $table->integer('shared_users')->nullable();
            $table->boolean('is_radius')->default(false);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
