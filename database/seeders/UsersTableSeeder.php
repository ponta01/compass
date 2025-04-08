<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Hashも必要です


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            ['over_name' => '渋沢',
            'under_name' => '栄一',
            'over_name_kana' => 'シブサワ',
            'under_name_kana' =>'エイイチ',
            'mail_address' => 'eiichi@shibusawa.com',
            'sex' => '1',
            'birth_day' => '1840-03-16',
            'role' => '1',
            'password' => Hash::make('imperial'),
        ]);
    }
}
