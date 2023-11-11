<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
            'name' => 'カット',
            'memo' => 'カットの詳細',
            'price' => 6000,
            'created_at' => new DateTime(),
            ],
            [
            'name' => 'カラー',
            'memo' => 'カラーの詳細',
            'price' => 8000,
            'created_at' => new DateTime(),
            ],
            [
            'name' => 'パーマ(カット込み)',
            'memo' => 'パーマの詳細',
            'price' => 13000,
            'created_at' => new DateTime(),
            ]
        ]);
    }
}
