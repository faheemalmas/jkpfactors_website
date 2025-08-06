<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ctf_data_stores', function (Blueprint $table) {
            $table->string('wrds_image_access')->nullable()->after('wrds_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ctf_data_stores', function (Blueprint $table) {
            $table->dropColumn('wrds_image_access');
        });
    }
};
