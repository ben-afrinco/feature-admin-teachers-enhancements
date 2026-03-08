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
        Schema::table('user', function (Blueprint $table) {
            $table->text('full_name')->change();
        });

        // Encrypt all existing full names
        $users = \Illuminate\Support\Facades\DB::table('user')->get();
        foreach ($users as $user) {
            // Only encrypt if it's not already encrypted (looks for JSON structure payload base64 encoded)
            if (!str_starts_with($user->full_name, 'eyJp')) {
                \Illuminate\Support\Facades\DB::table('user')->where('user_id', $user->user_id)->update([
                    'full_name' => encrypt($user->full_name)
                ]);
            }
        }
    }

    public function down(): void
    {
        // Decrypt all existing full names
        $users = \Illuminate\Support\Facades\DB::table('user')->get();
        foreach ($users as $user) {
            try {
                $decrypted = decrypt($user->full_name);
                \Illuminate\Support\Facades\DB::table('user')->where('user_id', $user->user_id)->update([
                    'full_name' => $decrypted
                ]);
            } catch (\Exception $e) {
                // If it fails to decrypt, assume it's already plain text
            }
        }

        Schema::table('user', function (Blueprint $table) {
            $table->string('full_name', 100)->change();
        });
    }
};
