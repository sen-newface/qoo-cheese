<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User([
            'name' => '千太郎',
            'email' => 'sentaro@sentaro.com',
            'password' => 'sentaro'
        ]);
        $user->save();

        $user = new \App\User([
            'name' => '千洋子',
            'email' => 'senyoko@senyoko.com',
            'password' => 'senyoko'
        ]);
        $user->save();

        $user = new \App\User([
            'name' => '千次郎',
            'email' => 'senjiro@senjiro.com',
            'password' => 'senjiro'
        ]);
        $user->save();
    }
}
