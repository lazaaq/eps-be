<?php

use Illuminate\Database\Seeder;

class QuizCategorysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('quiz_categorys')->delete();
        
        \DB::table('quiz_categorys')->insert(array (
            0 => 
            array (
                'id' => 1,
                'root' => 'Tes Kemampuan',
                'name' => 'Tes Kemampuan',
                'description' => 'Tes Kemampuan',
                'pic_url' => NULL,
                'created_at' => '2020-11-01 10:02:27',
                'updated_at' => '2020-11-01 10:02:27',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Hangeul',
                'description' => 'Tebak Hangeul',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:02:27',
                'updated_at' => '2020-11-08 10:02:27',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Suku Kata',
                'description' => 'Tebak Suku Kata',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Kata',
                'description' => 'Tebak Kata',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Kalimat',
                'description' => 'Tebak Kalimat',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Hallyu',
                'description' => 'Tebak Hallyu',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'root' => 'Tebak Korea',
                'name' => 'Tebak Angka',
                'description' => 'Tebak Angka',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 1',
                'description' => 'Level 1',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:06:37',
                'updated_at' => '2020-11-08 10:06:37',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 2',
                'description' => 'Level 2',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:06:37',
                'updated_at' => '2020-11-08 10:06:37',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 3',
                'description' => 'Level 3',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:07:30',
                'updated_at' => '2020-11-08 10:07:30',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 4',
                'description' => 'Level 4',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:07:30',
                'updated_at' => '2020-11-08 10:07:30',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 5',
                'description' => 'Level 5',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:07:30',
                'updated_at' => '2020-11-08 10:07:30',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 6',
                'description' => 'Level 6',
                'pic_url' => '',
                'created_at' => '2020-11-08 10:07:30',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'root' => 'Master Class Bahasa Korea',
                'name' => 'Level 7',
                'description' => 'Level 7',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:03:39',
                'updated_at' => '2020-11-08 10:03:39',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 1',
                'description' => 'Level 1',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 2',
                'description' => 'Level 2',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 3',
                'description' => 'Level 3',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 4',
                'description' => 'Level 4',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 5',
                'description' => 'Level 5',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 6',
                'description' => 'Level 6',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'root' => 'Kursus Bahasa Korea Umum',
                'name' => 'Level 7',
                'description' => 'Level 7',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:09:29',
                'updated_at' => '2020-11-08 10:09:29',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'root' => 'Kursus Topik',
                'name' => 'Level 1',
                'description' => 'Level 1',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'root' => 'Kursus Topik',
                'name' => 'Level 2',
                'description' => 'Level 2',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'root' => 'Kursus Topik',
                'name' => 'Level 3',
                'description' => 'Level 3',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'root' => 'Kursus Topik',
                'name' => 'Level 4',
                'description' => 'Level 4',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'root' => 'Kursus Topik',
                'name' => 'Level 5',
                'description' => 'Level 5',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'root' => 'Kursus Topik',
                'name' => 'Level 6',
                'description' => 'Level 6',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'root' => 'Kursus Topik',
                'name' => 'Level 7',
                'description' => 'Level 7',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:12:11',
                'updated_at' => '2020-11-08 10:12:11',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 1',
                'description' => 'Level 1',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:16:34',
                'updated_at' => '2020-11-08 10:16:34',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 2',
                'description' => 'Level 2',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 3',
                'description' => 'Level 3',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 4',
                'description' => 'Level 4',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 5',
                'description' => 'Level 5',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 6',
                'description' => 'Level 6',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'root' => 'Kursus Eps-Topik',
                'name' => 'Level 7',
                'description' => 'Level 7',
                'pic_url' => NULL,
                'created_at' => '2020-11-08 10:17:24',
                'updated_at' => '2020-11-08 10:17:24',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}