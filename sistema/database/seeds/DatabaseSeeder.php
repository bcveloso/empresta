<?php

use App\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Teste' , 
            'email'     => 'teste@teste.com.br' , 
            'password'  => bcrypt('teste@123')
        ]);
    }
}
