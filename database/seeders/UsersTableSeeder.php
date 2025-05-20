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
                'name' => '永城稜',
                'password' => Hash::make('password123'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1322303@st.kobedenshi.ac.jp',
            ],
            [
                'name' => '佐藤辰哉',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1371234@st.kobedenshi.ac.jp',
            ],
            [
                'name' => '関拓海',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1326575@st.kobedenshi.ac.jp',
            ],
            [
                'name' => '鈴木琉平',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1340410@st.kobedenshi.ac.jp',
            ],
            [
                'name' => '田上翔彌',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1316633@st.kobedenshi.ac.jp',
            ],
            [
                'name' => '吉田蒼梧',
                'password' => Hash::make('password456'),
                'photo' => null,
                'locked_flg' => 0,
                'error_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'email' => 'kd1318609@st.kobedenshi.ac.jp',
            ],
        ]);
    }
}

