<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToPrenomInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->default('')->change(); // Définir une valeur par défaut
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->default(null)->change(); // Rétablir la valeur par défaut à null
        });
    }
}
