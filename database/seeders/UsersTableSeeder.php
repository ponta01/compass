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
            ['over_name' => '織田',
            'under_name' => '信長',
            'over_name_kana' => 'オダ',
            'under_name_kana' =>'ノブナガ',
            'mail_address' => 'nobunaga.oda@atlas.com',
            'sex' => '1',
            'birth_day' => '1534-06-23',
            'role' => '4',
            'password' => Hash::make('nobunaga123'),
        ]);

    }
}
