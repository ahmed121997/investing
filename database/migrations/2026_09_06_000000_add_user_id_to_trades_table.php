<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table): void {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        DB::table('trades')->whereNull('user_id')->update(['user_id' => 1]);
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
