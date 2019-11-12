<?php

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
        factory(\App\User::class, 1)->create();
        factory(\App\Models\Customer::class, 1)->create();
        $this->call(SettingsTableSeeder::class);
//        $this->call(ChangeLogsTableSeeder::class);
    }
}
