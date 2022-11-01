<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $laravel = Category::create(['name' => 'laravel']);
        $php= Category::create(['category_name' => 'php']);
    }
}