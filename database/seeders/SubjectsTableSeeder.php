<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 国語、数学、英語を追加
        DB::table('subjects')->insert([
            ['subject' => '国語'],
            ['subject' => '数学'],
            ['subject' => '英語'],
        ]);

        // main_categoriesに「教科」を追加
        $mainCategoryId = DB::table('main_categories')->insertGetId([
            'main_category' => '教科',
        ]);


        // sub_categoriesに「国語、数学、英語」を追加
        DB::table('sub_categories')->insert([
            ['main_category_id' => $mainCategoryId, 'sub_category' => '国語'],
            ['main_category_id' => $mainCategoryId, 'sub_category' =>'数学'],
            ['main_category_id' => $mainCategoryId, 'sub_category' =>'英語'],
        ]);
    }
}
