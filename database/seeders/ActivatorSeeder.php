<?php

namespace Database\Seeders;

use App\Models\Activator;
use Illuminate\Database\Seeder;

class ActivatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activator::create([
            'domain'=>'abc',
            'key'=>'efg'
        ]);
    }
}
