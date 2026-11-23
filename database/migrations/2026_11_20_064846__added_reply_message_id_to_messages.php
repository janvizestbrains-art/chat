<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('messages', 'reply_message_id')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->foreignId('reply_message_id')
                    ->nullable()
                    ->constrained('messages')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('messages', 'reply_message_id')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['reply_message_id']);
                $table->dropColumn('reply_message_id');
            });
        }
    }
};
