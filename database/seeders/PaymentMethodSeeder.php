<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Default (personal)',
            'number' => '1234',
        ]);
        PaymentMethod::create([
            'name' => 'Default (agent)',
            'number' => '5678',
        ]);
    }
}
