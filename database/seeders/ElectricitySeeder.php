<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ElectricitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('electricities')->insert([
            'status' => 'Exist',
        ]);

        DB::table('electricities')->insert([
            'status' => 'notExist',
        ]);
    }
}
