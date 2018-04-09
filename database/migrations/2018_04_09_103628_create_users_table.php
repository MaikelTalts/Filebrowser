<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('email', 100);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_privileges')->length(1)->default(1);
            $table->integer('user_upload_privilege')->length(1)->default(1);
        });

        // Insert some stuff
    DB::table('users')->insert(
        array(
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('1q2w3e4r'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_privileges' => 2,
            'user_upload_privilege' => 2
        )
    );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
