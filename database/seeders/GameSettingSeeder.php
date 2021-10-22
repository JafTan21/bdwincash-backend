<?php

namespace Database\Seeders;

use App\Models\GameSetting;
use Illuminate\Database\Seeder;

class GameSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameSetting::create([
            'game_name' => 'headtail',
        ]);
        GameSetting::create([
            'game_name' => 'evenodd',
        ]);
        GameSetting::create([
            'game_name' => 'kings',
        ]);
        GameSetting::create([
            'game_name' => 'ludo',
        ]);
    }
}
