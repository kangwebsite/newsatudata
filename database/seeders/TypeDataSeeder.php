<?php

namespace Database\Seeders;

use App\Models\TypeData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'File Download', 'icon' => 'ph ph-download'],
            ['name' => 'Buku', 'icon' => 'ph ph-book'],
            ['name' => 'Grafik', 'icon' => 'ph ph-chart-bar']
        ];

        foreach ($data as $item) {
            TypeData::create(['name' => $item['name'], 'icon' => $item['icon']]);
        }
    }
}
