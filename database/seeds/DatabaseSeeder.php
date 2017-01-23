<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeasonsTableSeeder::class);
        $this->call(RoundsTableSeeder::class);
        $this->call(MatchesTableSeeder::class);
        $this->call(PlayersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
    }
}
