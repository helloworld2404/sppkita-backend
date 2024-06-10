<?php

namespace Database\Seeders;

use App\Model\User;

use Illuminate\Database\Seeder;

class akun extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'=>'izza',
                'email'=>'izza@gmail.com',
                'password'=> bcrypt('password'),
                'role'=> 1
            ],

            [
                'name'=>'udin',
                'email'=>'udin@gmail.com',
                'password'=> bcrypt('password'),
                'role'=> 2
            ],

            [
                'name'=>'asep',
                'email'=>'asep@gmail.com',
                'password'=> bcrypt('password'),
                'role'=> 3
            ],
        ];
        foreach($data as $key => $d){
            User::create($d);
        }
    }
}
