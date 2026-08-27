<?php

namespace Database\Seeders;

use App\Models\CategoryData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Pendidikan', 'status' => true],
            ['name' => 'Kesehatan', 'status' => true],
            ['name' => 'Infrastruktur', 'status' => true],
            ['name' => 'Ekonomi', 'status' => true],
            ['name' => 'Sosial', 'status' => true],
            ['name' => 'Pemerintahan', 'status' => true],
            ['name' => 'Lain-lain', 'status' => true],
            ['name' => 'Geografis', 'status' => true],
            ['name' => 'Kependudukan', 'status' => true],
            ['name' => 'Tenaga Kerja', 'status' => true],
            ['name' => 'Perkebunan', 'status' => true],
            ['name' => 'Pertanian', 'status' => true],
        ];

        foreach ($data as $item){
            CategoryData::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'status' => $item['status']
            ]);
        }

    }
}
