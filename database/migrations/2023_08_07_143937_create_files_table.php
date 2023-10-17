<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('ext'); //files extension
            $table->integer('original_size'); // files size
            $table->string('formatted_size_unit'); //files size unit
            $table->string('mime_type'); //files mime type
            $table->string('file_path'); //file path
            $table->string('file_link'); //file link
            $table->unsignedBigInteger('user_id'); //uploaded by
            $table->unsignedBigInteger('dept_id')->nullable(); //department id
            $table->unsignedBigInteger('parent_folder_id')->nullable(); //parent folder id
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('parent_folder_id')->references('id')->on('folders')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
