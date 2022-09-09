<?php

use Illuminate\Database\Seeder;

class QuizTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('quiz_types')->delete();
        
        \DB::table('quiz_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'quiz_category_id' => 2,
                'name' => 'Vokal',
                'description' => 'Vokal',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:34:15',
                'updated_at' => '2020-11-08 03:34:15',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'quiz_category_id' => 2,
                'name' => 'Konsonan',
                'description' => 'Konsonan',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:34:28',
                'updated_at' => '2020-11-08 03:34:28',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'quiz_category_id' => 3,
                'name' => 'Tebak Suku Kata',
                'description' => 'Tebak Suku Kata',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:34:42',
                'updated_at' => '2020-11-08 03:34:42',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'quiz_category_id' => 7,
                'name' => 'Tebak Angka Sino Korea',
                'description' => 'Tebak Angka Sino Korea',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:35:01',
                'updated_at' => '2020-11-08 03:35:01',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'quiz_category_id' => 7,
                'name' => 'Tebak Angka Asli Korea',
                'description' => 'Tebak Angka Asli Korea',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:35:11',
                'updated_at' => '2020-11-08 03:35:11',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'quiz_category_id' => 6,
                'name' => 'Agama',
                'description' => 'Agama',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:35:26',
                'updated_at' => '2020-11-08 03:35:26',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'quiz_category_id' => 6,
                'name' => 'Kata Gaul',
                'description' => 'Kata Gaul',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:35:42',
                'updated_at' => '2020-11-08 03:35:42',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'quiz_category_id' => 6,
                'name' => 'Sejarah',
                'description' => 'Sejarah',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:35:52',
                'updated_at' => '2020-11-08 03:35:52',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'quiz_category_id' => 6,
                'name' => 'Politik',
                'description' => 'Politik',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:36:10',
                'updated_at' => '2020-11-08 03:36:10',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'quiz_category_id' => 6,
                'name' => 'Wisata',
                'description' => 'Wisata',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:36:19',
                'updated_at' => '2020-11-08 03:36:19',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'quiz_category_id' => 6,
                'name' => 'K-Pop',
                'description' => 'K-Pop',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:36:35',
                'updated_at' => '2020-11-08 03:36:35',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'quiz_category_id' => 6,
                'name' => 'Ekonomi',
                'description' => 'Ekonomi',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:36:50',
                'updated_at' => '2020-11-08 03:36:50',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'quiz_category_id' => 5,
                'name' => 'Istilah di Tempat Kerja Korea',
                'description' => 'Istilah di Tempat Kerja Korea',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:37:16',
                'updated_at' => '2020-11-08 03:37:16',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'quiz_category_id' => 5,
                'name' => 'Serba-Serbi Korea',
                'description' => 'Serba-Serbi Korea',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:37:24',
                'updated_at' => '2020-11-08 03:37:24',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'quiz_category_id' => 5,
                'name' => 'Kehidupan di Lingkungan Kerja',
                'description' => 'Kehidupan di Lingkungan Kerja',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:37:33',
                'updated_at' => '2020-11-08 03:37:33',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'quiz_category_id' => 5,
                'name' => 'Kehidupan Dasar Korea',
                'description' => 'Kehidupan Dasar Korea',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:37:41',
                'updated_at' => '2020-11-08 03:37:41',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'quiz_category_id' => 5,
                'name' => 'Lembaga Pemerintah',
                'description' => 'Lembaga Pemerintah',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:37:55',
                'updated_at' => '2020-11-08 03:37:55',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'quiz_category_id' => 4,
                'name' => 'Kehidupan Sehari-Hari dan Hobi',
                'description' => 'Kehidupan Sehari-Hari dan Hobi',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:38:23',
                'updated_at' => '2020-11-08 03:38:23',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'quiz_category_id' => 4,
                'name' => 'Budaya Kerja',
                'description' => 'Budaya Kerja',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-11-08 03:38:34',
                'updated_at' => '2020-11-08 03:38:34',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'quiz_category_id' => 8,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'quiz_category_id' => 8,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'quiz_category_id' => 9,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'quiz_category_id' => 9,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'quiz_category_id' => 10,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'quiz_category_id' => 10,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'quiz_category_id' => 11,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'quiz_category_id' => 11,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'quiz_category_id' => 12,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'quiz_category_id' => 12,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'quiz_category_id' => 13,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'quiz_category_id' => 13,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'quiz_category_id' => 14,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'quiz_category_id' => 14,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'quiz_category_id' => 15,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'quiz_category_id' => 15,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'quiz_category_id' => 15,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'quiz_category_id' => 16,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'quiz_category_id' => 16,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'quiz_category_id' => 16,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'quiz_category_id' => 17,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'quiz_category_id' => 17,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'quiz_category_id' => 17,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'quiz_category_id' => 18,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'quiz_category_id' => 18,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'quiz_category_id' => 18,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'quiz_category_id' => 19,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'quiz_category_id' => 19,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'quiz_category_id' => 19,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'quiz_category_id' => 20,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'quiz_category_id' => 20,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'quiz_category_id' => 20,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'quiz_category_id' => 21,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'quiz_category_id' => 21,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'quiz_category_id' => 21,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'quiz_category_id' => 22,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'quiz_category_id' => 22,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'quiz_category_id' => 22,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'quiz_category_id' => 23,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'quiz_category_id' => 23,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'quiz_category_id' => 23,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'quiz_category_id' => 24,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'quiz_category_id' => 24,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'quiz_category_id' => 24,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'quiz_category_id' => 25,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'quiz_category_id' => 25,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'quiz_category_id' => 25,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'quiz_category_id' => 26,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'quiz_category_id' => 26,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'quiz_category_id' => 26,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'quiz_category_id' => 27,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'quiz_category_id' => 27,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'quiz_category_id' => 27,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'quiz_category_id' => 28,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'quiz_category_id' => 28,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'quiz_category_id' => 28,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'quiz_category_id' => 29,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'quiz_category_id' => 29,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'quiz_category_id' => 29,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'quiz_category_id' => 30,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'quiz_category_id' => 30,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'quiz_category_id' => 30,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'quiz_category_id' => 31,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'quiz_category_id' => 31,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'quiz_category_id' => 31,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'quiz_category_id' => 32,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'quiz_category_id' => 32,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'quiz_category_id' => 32,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'quiz_category_id' => 33,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'quiz_category_id' => 33,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'quiz_category_id' => 33,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'quiz_category_id' => 34,
                'name' => 'Non Interactive',
                'description' => 'Non Interactive',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'quiz_category_id' => 34,
                'name' => 'Private',
                'description' => 'Private',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'quiz_category_id' => 34,
                'name' => 'Group',
                'description' => 'Group',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'quiz_category_id' => 35,
                'name' => 'Paket 1',
                'description' => 'Paket 1',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            94 => 
            array (
                'id' => 95,
                'quiz_category_id' => 35,
                'name' => 'Paket 2',
                'description' => 'Paket 2',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            95 => 
            array (
                'id' => 96,
                'quiz_category_id' => 35,
                'name' => 'Paket 3',
                'description' => 'Paket 3',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            96 => 
            array (
                'id' => 97,
                'quiz_category_id' => 35,
                'name' => 'Paket 4',
                'description' => 'Paket 4',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
            97 => 
            array (
                'id' => 98,
                'quiz_category_id' => 35,
                'name' => 'Paket 5',
                'description' => 'Paket 5',
                'pic_url' => 'blank.jpg',
                'created_at' => '2020-12-20 03:35:09',
                'updated_at' => '2020-12-20 03:35:09',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}