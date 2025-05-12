<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
        DB::table('users')->insert([
            [
                'name' => 'Taro Yamada',
                'mail_address' => 'kd1322303@st.kobedenshi.ac.jp',
                'password' => Hash::make('password123'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hanako Tanaka',
                'mail_address' => 'hanako@example.com',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

