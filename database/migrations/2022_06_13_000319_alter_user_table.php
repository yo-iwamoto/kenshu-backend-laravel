<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // email_verified_at カラムを削除
            $table->dropColumn('email_verified_at');

            // name カラムの最大文字数を 50 に指定
            $table->string('name', 50)->change();

            // email カラムの最大文字数を 255 に指定
            $table->string('email', 255)->change();

            // profile_image_url カラムを追加
            $table->string('profile_image_url', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name')->change();
            $table->string('email')->change();
            $table->dropColumn('profile_image_url');
        });
    }
};
