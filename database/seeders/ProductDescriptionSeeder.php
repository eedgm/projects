<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductDescription;

class ProductDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductDescription::factory()
            ->count(5)
            ->create();
    }
}
