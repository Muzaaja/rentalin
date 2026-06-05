<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik & Gadget',
                'slug' => 'elektronik-gadget'
            ],
            [
                'name' => 'Fashion & Aksesoris',
                'slug' => 'fashion-aksesoris'
            ],
            [
                'name' => 'Pesta & Event',
                'slug' => 'pesta-event'
            ],
            [
                'name' => 'Rumah Tangga',
                'slug' => 'rumah-tangga'
            ],
            [
                'name' => 'Hobi & Olahraga',
                'slug' => 'hobi-olahraga'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}