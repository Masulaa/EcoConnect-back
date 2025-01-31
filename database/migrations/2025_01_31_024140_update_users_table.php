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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('epcg_naplatni_broj')->nullable();
            $table->string('epcg_broj_brojila')->nullable();
            #$table->string('water_meter_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('phone_number');
            $table->dropColumn('epcg_naplatni_broj');
            $table->dropColumn('epcg_broj_brojila');
        });
    }
};
