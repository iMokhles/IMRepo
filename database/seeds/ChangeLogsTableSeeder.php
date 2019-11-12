<?php

use Illuminate\Database\Seeder;

class ChangeLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('change_logs')->delete();
        
        \DB::table('change_logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'package_id' => 1,
                'user_id' => 1,
                'changes' => '[{"change":"* first release"}]',
                'package_version' => '1',
                'package_hash' => 'ykKhac5HesGNJJnu5l7hyWX6WWdgb6',
                'package_identifier' => 'com.imokhles.dzsnap2',
                'created_at' => '2019-11-11 16:59:31',
                'updated_at' => '2019-11-11 17:02:16',
            ),
        ));
        
        
    }
}