<?php

class YewLanguagesSeeder extends DatabaseSeeder {

    public function run()
    {
        DB::table('yew_languages')->truncate();

        DB::table('yew_languages')->insert([
            ['id' => 1, 'country_code' => 'GB', 'language_code' => 'en-gb', 'language' => 'English (UK)'],
            ['id' => 2, 'country_code' => 'US', 'language_code' => 'en-us', 'language' => 'English (US)'],
            ['id' => 3, 'country_code' => 'ES', 'language_code' => 'es-es', 'language' => 'Spanish'],
            ['id' => 4, 'country_code' => 'FR', 'language_code' => 'fr-fr', 'language' => 'French'],
            ['id' => 5, 'country_code' => 'DE', 'language_code' => 'de', 'language' => 'German'],
            ['id' => 6, 'country_code' => 'IT', 'language_code' => 'it', 'language' => 'Italian'],
            ['id' => 7, 'country_code' => 'SA', 'language_code' => 'ar-sa', 'language' => 'Arabic'],
            ['id' => 8, 'country_code' => 'BG', 'language_code' => 'bg', 'language' => 'Bulgarian'],
            ['id' => 9, 'country_code' => 'CZ', 'language_code' => 'cz', 'language' => 'Czech'],
            ['id' => 10, 'country_code' => 'CN', 'language_code' => 'zh', 'language' => 'Chinese (Mandarin)'],
            ['id' => 11, 'country_code' => 'DK', 'language_code' => 'da', 'language' => 'Danish'],
            ['id' => 12, 'country_code' => 'EE', 'language_code' => 'et', 'language' => 'Estonian'],
            ['id' => 13, 'country_code' => 'FI', 'language_code' => 'fi', 'language' => 'Finnish'],
            ['id' => 14, 'country_code' => 'IN', 'language_code' => 'hi', 'language' => 'Hindi'],
            ['id' => 15, 'country_code' => 'HR', 'language_code' => 'hr', 'language' => 'Croatian'],
            ['id' => 16, 'country_code' => 'HU', 'language_code' => 'hu', 'language' => 'Hungarian'],
            ['id' => 17, 'country_code' => 'IS', 'language_code' => 'is', 'language' => 'Icelandic'],
            ['id' => 18, 'country_code' => 'JP', 'language_code' => 'ja', 'language' => 'Japanese'],
            ['id' => 19, 'country_code' => 'LV', 'language_code' => 'lv', 'language' => 'Latvian'],
            ['id' => 20, 'country_code' => 'LT', 'language_code' => 'lt', 'language' => 'Lithuanian'],
            ['id' => 21, 'country_code' => 'NL', 'language_code' => 'nl', 'language' => 'Dutch'],
            ['id' => 22, 'country_code' => 'NO', 'language_code' => 'no', 'language' => 'Norwegian'],
            ['id' => 23, 'country_code' => 'PL', 'language_code' => 'po', 'language' => 'Polish'],
            ['id' => 24, 'country_code' => 'RO', 'language_code' => 'ro', 'language' => 'Romanian'],
            ['id' => 25, 'country_code' => 'RU', 'language_code' => 'ru', 'language' => 'Russian'],
            ['id' => 26, 'country_code' => 'SK', 'language_code' => 'sk', 'language' => 'Slovak'],
            ['id' => 27, 'country_code' => 'SE', 'language_code' => 'sv', 'language' => 'Swedish']
        ]);
    }
}