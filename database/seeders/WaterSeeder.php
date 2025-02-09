<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('waters')->insert([
            'status' => 'Exist',
        ]);

        DB::table('waters')->insert([
            'status' => 'notExist',
        ]);
    }
}
