<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = new App\User;
        $user->name = 'Finder';
        $user->email = 'm@m-finder.com';
        $user->sign = '我讨厌说话太多,就像我讨厌走路太慢.';
        $user->password = Hash::make('111111');
        $user->is_author = 2;
        $user->save();
    }

}
