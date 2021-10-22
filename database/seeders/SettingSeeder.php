<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name'=>'withdraw',
        ]);
        Setting::create([
            'name'=>'deposit',
        ]);
        Setting::create([
            'name'=>'transfer',
        ]);
        Setting::create([
            'name'=>'min_balance',
        ]);
    }
}
