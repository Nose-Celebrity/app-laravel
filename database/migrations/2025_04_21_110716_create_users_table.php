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

        //フラグ/エラー追加

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('name');
            $table->str('password');
            $table->string('photo')->nullable();
            $table->tinyInteger('locked_flg')->default(0);
            $table->integer('error_count')->unsigned()->default(0);
            $table->timestamps();

            $table->string('mail_address')->nullable();
            /*
            *$table->string('mail_address')->unique();
            *正規のコード
            */

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
