<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('games', function (Blueprint $table) {
        $table->longText('lore_description')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('games', function (Blueprint $table) {
        $table->dropColumn('lore_description');
    });
}
};
