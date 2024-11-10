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
        Schema::create('rendezvous', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->time('heure_debut');
            $table->time('heure_fin')->nullable();
            $table->string('motif');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendezvous');
    }
};
