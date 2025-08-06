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
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('model_name');
            $table->string('csv_file_path'); // URL of the CSV file
            $table->string('python_file_path'); // URL of the Python file
            $table->string('original_csv_filename');
            $table->string('original_py_filename');
            $table->integer('send_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_uploads');
    }
};
