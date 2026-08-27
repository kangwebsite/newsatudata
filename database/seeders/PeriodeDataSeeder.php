<?php

namespace Database\Seeders;

use App\Models\PeriodeData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Bulanan', 'Triwulan', 'Semester', 'Tahunan'];

        foreach ($data as $item) {
            PeriodeData::create(['name' => $item]);
        }
    }
}
