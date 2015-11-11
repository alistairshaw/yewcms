<?php

class YewSettingsSeeder extends DatabaseSeeder {

    public function run()
    {
        DB::table('yew_settings')->truncate();

        DB::table('yew_settings')->insert([
            ['id' => 1, 'setting' => 'Logo', 'default_value' => ''],
            ['id' => 2, 'setting' => 'Company Name', 'default_value' => 'My Company Name'],
            ['id' => 3, 'setting' => 'Address 1', 'default_value' => '123 Some Street'],
            ['id' => 4, 'setting' => 'Address 2', 'default_value' => ''],
            ['id' => 5, 'setting' => 'Address 3', 'default_value' => ''],
            ['id' => 6, 'setting' => 'City/Town', 'default_value' => 'Nottingham'],
            ['id' => 7, 'setting' => 'Postcode', 'default_value' => 'NG3 4GN'],
            ['id' => 8, 'setting' => 'State/County', 'default_value' => ''],
            ['id' => 9, 'setting' => 'Country', 'default_value' => ''],
            ['id' => 10, 'setting' => 'Telephone', 'default_value' => '0800 123 456'],
            ['id' => 11, 'setting' => 'Secondary Telephone', 'default_value' => ''],
            ['id' => 12, 'setting' => 'Primary Email Address', 'default_value' => 'info@yewcms.com'],
            ['id' => 13, 'setting' => 'Opening Hours', 'default_value' => "Mon - Fri 10am - 6pm\nSaturday 10am - 3pm"],
            ['id' => 14, 'setting' => 'Twitter', 'default_value' => '@yewcms'],
            ['id' => 15, 'setting' => 'Facebook', 'default_value' => 'http://facebook.com'],
            ['id' => 16, 'setting' => 'Google Plus', 'default_value' => 'http://google.com/+'],
            ['id' => 17, 'setting' => 'LinkedIn', 'default_value' => 'http://linkedin.com'],
            ['id' => 18, 'setting' => 'Instagram', 'default_value' => ''],
            ['id' => 19, 'setting' => 'Pinterest', 'default_value' => ''],
            ['id' => 20, 'setting' => 'Tumblr', 'default_value' => ''],
            ['id' => 21, 'setting' => 'Default Meta Description', 'default_value' => 'Powered by Yew CMS'],
            ['id' => 22, 'setting' => 'Default Meta Keywords', 'default_value' => ''],
            ['id' => 23, 'setting' => 'Default Language', 'default_value' => 'en-uk']
        ]);
    }
}