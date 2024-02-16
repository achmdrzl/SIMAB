<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'          =>  'ADMIN',
            'email'         => 'admin@gmail.com',
            'phone_number'  => '08182312319',
            'password'      => bcrypt('password'),
            'role'          => 'admin',
        ]);

        $admin->assignRole('admin');

        $pimpinan = User::create([
            'name'          =>  'PIMPINAN',
            'email'         => 'pimpinan@gmail.com',
            'phone_number'  => '08182312319',
            'password'      => bcrypt('password'),
            'role'          => 'pimpinan',
        ]);

        $pimpinan->assignRole('pimpinan');

        $lapangan = User::create([
            'name'          =>  'PENGAWAS LAPANGAN',
            'email'         => 'pengawas-lapangan@gmail.com',
            'phone_number'  => '08182312319',
            'password'      => bcrypt('password'),
            'role'          => 'pengawas-lapangan',
        ]);

        $lapangan->assignRole('pengawas-lapangan');
    }
}
