<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Player::class, 50)->create()->each(function ($u) {
            $u->teams()->save(factory(App\Team::class)->make());
        });
    }
}
