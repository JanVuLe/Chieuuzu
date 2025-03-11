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
        Schema::table('discounts', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->enum('apply_type', ['product', 'category'])->after('percentage');
            $table->unsignedBigInteger('apply_id')->after('apply_type');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('end_date');
            $table->index(['apply_type', 'apply_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn(['slug', 'apply_type', 'apply_id', 'status']);
        });
    }
};
