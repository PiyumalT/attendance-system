<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignOutsTable extends Migration
{
    public function up()
    {
        Schema::create('sign_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['on_time', 'early', 'absent'])->default('on_time');
            $table->timestamp('timestamp');
            $table->foreignId('sign_in_id')->constrained('sign_ins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sign_outs');
    }
}
