<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'release_origin',
                'name' => 'Release Origin',
                'description' => 'Repo Origin',
                'value' => 'iMokhles',
                'field' => '{"name":"value","label":"Value","type":"text"}',
                'active' => 1,
                'created_at' => '2019-02-25 12:51:37',
                'updated_at' => '2019-02-25 12:51:49',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'release_label',
                'name' => 'Release Label',
                'description' => 'Repo Label',
                'value' => 'iMokhles repo',
                'field' => '{"name":"value","label":"Value","type":"text"}',
                'active' => 1,
                'created_at' => '2019-02-25 12:52:52',
                'updated_at' => '2019-02-25 12:54:11',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'release_version',
                'name' => 'Release Version',
                'description' => 'Repo Version',
                'value' => '1.0',
                'field' => '{"name":"value","label":"Value","type":"text"}',
                'active' => 1,
                'created_at' => '2019-02-25 12:54:33',
                'updated_at' => '2019-02-25 12:55:45',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'release_description',
                'name' => 'Release Description',
                'description' => 'Repo Description',
                'value' => 'iMokhles Personal Repo',
                'field' => '{"name":"value","label":"Value","type":"text"}',
                'active' => 1,
                'created_at' => '2019-02-25 12:56:29',
                'updated_at' => '2019-02-25 12:57:04',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'allow_protection',
                'name' => 'Allow Protection',
                'description' => 'Allow udids protection for packages',
                'value' => '1',
                'field' => '{"name":"value","label":"Value","type":"checkbox"}',
                'active' => 1,
                'created_at' => '2019-02-25 12:59:53',
                'updated_at' => '2019-02-25 13:00:16',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'enable_auto_build',
                'name' => 'Enable Auto Build',
                'description' => 'Auto build packages once you upload new debs',
                'value' => '1',
                'field' => '{"name":"value","label":"Value","type":"checkbox"}',
                'active' => 1,
                'created_at' => '2019-02-25 13:00:42',
                'updated_at' => '2019-02-25 13:00:49',
            ),
            6 => array (
                'id' => 7,
                'key'           => 'site_url',
                'name'          => 'Site Url in Depiction',
                'description'   => 'Site url which will appear in depiction page',
                'value'         => "http://imokhles.com",
                'field'         => '{"name":"value","label":"Support URL", "title":"IMRepo" ,"type":"text"}',
                'active'        => 1,
                'created_at' => '2019-02-25 12:59:53',
                'updated_at' => '2019-02-25 13:00:16',
            ),
            7 => array (
                'id' => 8,
                'key'           => 'donate_url',
                'name'          => 'Donate Url in Depiction',
                'description'   => 'Donate url which will appear in depiction page',
                'value'         => "http://imokhles.com",
                'field'         => '{"name":"value","label":"Support URL", "title":"IMRepo" ,"type":"text"}',
                'active'        => 1,
                'created_at' => '2019-02-25 12:59:53',
                'updated_at' => '2019-02-25 13:00:16',
            ),
            8 => array (
                'id' => 9,
                'key'           => 'support_url',
                'name'          => 'Support Url in Depiction',
                'description'   => 'Support url which will appear in depiction page',
                'value'         => "http://imokhles.com",
                'field'         => '{"name":"value","label":"Support URL", "title":"IMRepo" ,"type":"text"}',
                'active'        => 1,
                'created_at' => '2019-02-25 12:59:53',
                'updated_at' => '2019-02-25 13:00:16',
            )
        ));
        
        
    }
}