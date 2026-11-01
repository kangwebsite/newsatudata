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
            ['name' => 'File Download', 'icon' => 'ph ph-download', 'color' => '#3B82F6'],
            ['name' => 'Buku', 'icon' => 'ph ph-book', 'color' => '#10B981'],
            ['name' => 'Grafik', 'icon' => 'ph ph-chart-bar', 'color' => '#F59E0B']
        ];

        foreach ($data as $item) {
            TypeData::create(['name' => $item['name'], 'icon' => $item['icon'], 'color' => $item['color']]);
        }
    }
}
