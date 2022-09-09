<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('components')->delete();

        \DB::table('components')->insert(array (
            0 =>
            array (
                'com_cd' => 'PAYMENT_METHOD_1',
                'code_nm' => 'BNI Syariah',
                'code_group' => 'PAYMENT_METHOD',
                'code_value' => '33019283713',
                'note' => 'Adi Sem',
                'note2' => 'bni-syariah.png',
                'created_by' => NULL,
                'updated_by' => '1',
                'created_at' => NULL,
                'updated_at' => '2020-12-29 19:55:08',
            ),
            1 =>
            array (
                'com_cd' => 'PAYMENT_METHOD_2',
                'code_nm' => 'Mandiri',
                'code_group' => 'PAYMENT_METHOD',
                'code_value' => '1304813613183',
                'note' => 'Rifqi Sem',
                'note2' => 'mandiri.png',
                'created_by' => NULL,
                'updated_by' => '1',
                'created_at' => NULL,
                'updated_at' => '2020-12-29 20:16:17',
            ),
            2 =>
            array (
                'com_cd' => 'SOURCE_1',
                'code_nm' => 'Internal',
                'code_group' => 'SOURCE',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'com_cd' => 'SOURCE_2',
                'code_nm' => 'External',
                'code_group' => 'SOURCE',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'com_cd' => 'SOURCE_EX_PDF_1',
                'code_nm' => 'Google Drive',
                'code_group' => 'SOURCE_EX_PDF',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'com_cd' => 'SOURCE_EX_VID_1',
                'code_nm' => 'Google Drive',
                'code_group' => 'SOURCE_EX_VID',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'com_cd' => 'SOURCE_EX_VID_2',
                'code_nm' => 'Youtube',
                'code_group' => 'SOURCE_EX_VID',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'com_cd' => 'STATUS_TRANS_1',
                'code_nm' => 'Waiting for Payment',
                'code_group' => 'TRANS',
                'code_value' => '1',
                'note' => 'warning',
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'com_cd' => 'STATUS_TRANS_2',
                'code_nm' => 'Payment Confirmed',
                'code_group' => 'TRANS',
                'code_value' => '3',
                'note' => 'success',
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'com_cd' => 'STATUS_TRANS_3',
                'code_nm' => 'Failed',
                'code_group' => 'TRANS',
                'code_value' => '4',
                'note' => 'danger',
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'com_cd' => 'STATUS_TRANS_4',
                'code_nm' => 'Waiting for Confirmation',
                'code_group' => 'TRANS',
                'code_value' => '2',
                'note' => 'primary',
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'com_cd' => 'TYPE_FILE_1',
                'code_nm' => 'PDF',
                'code_group' => 'TYPE_FILE',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'com_cd' => 'TYPE_FILE_2',
                'code_nm' => 'Video',
                'code_group' => 'TYPE_FILE',
                'code_value' => NULL,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'com_cd' => 'SCORE_TRYOUT_1',
                'code_nm' => 'Score 5',
                'code_group' => 'SCORE_TRYOUT',
                'code_value' => 5,
                'note' => NULL,
                'note2' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
