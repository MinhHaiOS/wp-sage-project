<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LeagueSeeder::class,
            TeamSeeder::class,
            MatchSeeder::class,
        ]);
    }
}
