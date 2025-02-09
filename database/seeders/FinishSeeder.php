<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FinishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('finishes')->insert([
            'status' => 'Finished',
        ]);

        DB::table('finishes')->insert([
            'status' => 'semiFinished',
        ]);

        DB::table('finishes')->insert([
            'status' => 'notFinished',
        ]);


    }
}
