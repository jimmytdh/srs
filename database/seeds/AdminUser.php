<?php

use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'fname' => 'Jimmy',
            'lname' => 'Lomocso',
            'designation' => 1,
            'contact' => '0916 207 2427',
            'email' => 'jimmy.tdh@gmail.com',
            'sex' => 'Male',
            'dob' => '1990-09-23',
            'section' => 1,
            'address' => 'Guadalupe, Cebu City',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'level' => 'admin',
            'status' => 1,
            'picture' => 'default.png'
        ]);

        DB::table('user')->insert([
            'fname' => 'Rolly',
            'lname' => 'Samson',
            'designation' => 2,
            'contact' => '0912 345 6789',
            'email' => 'rolly.tdh@gmail.com',
            'sex' => 'Male',
            'dob' => '1995-05-25',
            'section' => 2,
            'address' => 'Mambaling, Cebu City',
            'username' => 'rolly',
            'password' => bcrypt('rolly'),
            'level' => 'standard',
            'status' => 1,
            'picture' => 'default.png'
        ]);

        DB::table('user')->insert([
            'fname' => 'Wairley Von',
            'lname' => 'Cabiluna',
            'designation' => 2,
            'contact' => '0912 345 6789',
            'email' => 'von.tdh@gmail.com',
            'sex' => 'Male',
            'dob' => '1990-12-12',
            'section' => 1,
            'address' => 'Lagtang, Talisay City',
            'username' => 'von',
            'password' => bcrypt('von'),
            'level' => 'standard',
            'status' => 1,
            'picture' => 'default.png'
        ]);

        DB::table('section')->insert([
            'initial' => 'IT',
            'code' => 'IHOMP',
            'division_id' => '1',
            'description' => 'Integrated Hospital Operation and Management Program'
        ]);

        DB::table('section')->insert([
            'initial' => 'PU',
            'code' => 'PU',
            'division_id' => '2',
            'description' => 'Procurement Unit'
        ]);

        DB::table('designation')->insert([
            'code' => 'CMT II',
            'description' => 'Computer Maintenance Technologist II'
        ]);

        DB::table('designation')->insert([
            'code' => 'NA II',
            'description' => 'Nursing Attendant II'
        ]);

        DB::table('division')->insert([
            'code' => 'MCC',
            'description' => 'Medical Center Chief'
        ]);

        DB::table('division')->insert([
            'code' => 'QMD',
            'description' => 'Quality Management Division'
        ]);
    }
}
