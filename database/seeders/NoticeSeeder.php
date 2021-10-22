<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notice::create([
            'text'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore hic debitis soluta fugiat laudantium? Fugit molestias dolores ipsam numquam libero.'
        ]);
    }
}
