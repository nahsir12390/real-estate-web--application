<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->index('user_id');
            }

            if (! Schema::hasColumn('profiles', 'phone')) {
                $table->string('phone', 20)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('profiles', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('profiles', 'avatar')) {
                $table->string('avatar')->nullable()->after('address');
            }

            if (! Schema::hasColumn('profiles', 'bio')) {
                $table->text('bio')->nullable()->after('avatar');
            }

            if (! Schema::hasColumn('profiles', 'whatsapp_number')) {
                $table->string('whatsapp_number', 20)->nullable()->after('bio');
            }

            if (! Schema::hasColumn('profiles', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('whatsapp_number');
            }

            if (! Schema::hasColumn('profiles', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('facebook_url');
            }

            if (! Schema::hasColumn('profiles', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('twitter_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $columns = [
                'instagram_url',
                'twitter_url',
                'facebook_url',
                'whatsapp_number',
                'bio',
                'avatar',
                'address',
                'phone',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('profiles', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('profiles', 'user_id')) {
                $table->dropIndex(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
