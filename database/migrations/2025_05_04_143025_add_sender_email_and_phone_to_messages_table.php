<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderEmailAndPhoneToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            if (! Schema::hasColumn('messages', 'sender_email')) {
                $table->string('sender_email')->nullable()->after('sender_id');
            }

            if (! Schema::hasColumn('messages', 'sender_phone')) {
                $table->string('sender_phone')->nullable()->after('sender_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['sender_email', 'sender_phone']);
        });
    }
}
