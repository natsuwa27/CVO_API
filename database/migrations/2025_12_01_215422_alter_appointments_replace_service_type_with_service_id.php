<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'service_type')) {
                $table->dropColumn('service_type');
            }
            $table->foreignId('service_id')->after('pet_id')->constrained('services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_id');
            $table->enum('service_type', ['consultation','vaccination','surgery','grooming'])->nullable();
        });
    }
};
