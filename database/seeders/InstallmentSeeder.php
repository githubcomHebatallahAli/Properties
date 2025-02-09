<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstallmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('installments')->insert([
            'status' => 'Cash',
        ]);

        DB::table('installments')->insert([
            'status' => 'Installment',
        ]);

        DB::table('installments')->insert([
            'status' => 'Monthly',
        ]);





    }
}
