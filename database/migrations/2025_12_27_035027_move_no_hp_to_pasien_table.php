<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pasien', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('alamat');
            }
        });
        
        // Data migration: copy no_hp from users to pasien where role is pasien
        $users = DB::table('users')->where('role', 'pasien')->get();
        foreach ($users as $user) {
            DB::table('pasien')
                ->where('user_id', $user->id)
                ->update(['no_hp' => $user->no_hp]);
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable();
        });

        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('no_hp');
        });
    }
};
