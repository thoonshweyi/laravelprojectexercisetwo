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
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedBigInteger("country_id")->after("slug");
            $table->unsignedBigInteger('region_id')->after("country_id");
            $table->unsignedBigInteger("status_id")->after("region_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn("country_id");
            $table->dropColumn("region_id");
            $table->dropColumn("status_id");
        });
    }
};
