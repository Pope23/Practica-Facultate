<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('quotes')->insert([
            ['client_name' => 'Ion Popescu', 'car_plate' => 'B123XYZ', 'insurer_name' => 'AsiguratorX', 'price' => 545.50],
            ['client_name' => 'Maria Ionescu', 'car_plate' => 'CJ45ABC', 'insurer_name' => 'AsiguratorY', 'price' => 480.00],
        ]);
    }
}
