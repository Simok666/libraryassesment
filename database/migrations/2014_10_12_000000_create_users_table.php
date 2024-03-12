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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('instance_name');
            $table->string('pic_name');
            $table->string('leader_instance_name')->nullable();
            $table->string('library_name')->nullable();
            $table->string('head_library_name')->nullable();
            $table->text('npp')->nullable();
            $table->text('address');
            $table->text('map_coordinates');
            $table->text('village');
            $table->text('subdistrict');
            $table->text('city');
            $table->text('province');
            $table->text('number_telephone');
            $table->text('website')->nullable();
            $table->text('library_email');
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
