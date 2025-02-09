<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('properties')->insert([
            'status' => 'Flat',
        ]);

        DB::table('properties')->insert([
            'status' => 'Land',
        ]);

        DB::table('properties')->insert([
            'status' => 'House',
        ]);

        DB::table('properties')->insert([
            'status' => 'Villa',
        ]);

        DB::table('properties')->insert([
            'status' => 'Chalet',
        ]);

        DB::table('properties')->insert([
            'status' => 'Shop',
        ]);

        DB::table('properties')->insert([
            'status' => 'Clinic',
        ]);

        DB::table('properties')->insert([
            'status' => 'Office',
        ]);
    }
}
