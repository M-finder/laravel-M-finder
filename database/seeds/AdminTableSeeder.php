<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $admin = new App\Admin;
        $admin->name = 'Finder';
        $admin->email = 'm@m-finder.com';
        $admin->password = Hash::make('111111');
        $admin->save();
    }

}
