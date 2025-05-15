<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('mail_address');
        });

        // mail_address を email にコピー
        User::all()->each(function ($user) {
            $user->email = $user->mail_address;
            $user->save();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};

