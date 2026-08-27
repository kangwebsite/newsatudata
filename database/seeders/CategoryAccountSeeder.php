<?php

namespace Database\Seeders;

use App\Models\CategoryAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['SKPD', 'Non SKPD'];

        foreach ($data as $item) {
            CategoryAccount::create(['name' => $item, 'slug' => Str::slug($item)]);
        }

    }
}
