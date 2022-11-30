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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message', 10000)->nullable();
            $table->string('file_path', 1000)->nullable()->default('text');
            $table->string('file_name', 1000)->nullable()->default('text');
            $table->timestamp('send_date')->useCurrent = true;
            $table->enum('type', ['text','image','document'])->nullable()->default('text');
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
