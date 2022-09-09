<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'Admin LPK']);

        $user = User::create([
            'name'      => 'Developer',
            'username'  => 'developer',
            'email'     => 'developer@dev.com',
            'password'  =>  bcrypt('devpass'),
            'picture'   => 'avatar.png',
        ]);
        $user->assignRole('admin');

        $lpk = \App\Lpk::create([
            'id'            => 'LPK-DEV',
            'name'          => 'LPK Dev',
            'address'       => 'Jl. LPK Dev No.77, Kota Yogyakarta',
            'phone_number'  => '088880088880',
            'created_by'   => 'seeder',
        ]);

        $admin_lpk = User::create([
            'name'      => 'Admin LPK Dev',
            'username'  => 'adminlpk',
            'email'     => 'adminlpk@dev.com',
            'password'  =>  bcrypt('devpass'),
            'picture'   => 'avatar.png',
            'lpk'       => 'LPK-DEV',
        ]);
        $admin_lpk->assignRole('Admin LPK');

        // $user = User::create([
        //     'name'      => 'User Dev',
        //     'username'  => 'userdev',
        //     'email'     => 'user@dev.com',
        //     'password'  =>  bcrypt('devpass'),
        //     'picture'   => 'avatar.png',
        //     'lpk'       => null,
        // ]);
        // $user->assignRole('user');
        // \DB::table('collagers')->insert([
        //     'user_id' => $user->id
        // ]);


        // $this->call(QuizCategorysTableSeeder::class);
        // $this->call(QuizTypesTableSeeder::class);
        $this->call(ComponentsTableSeeder::class);
    }
}
