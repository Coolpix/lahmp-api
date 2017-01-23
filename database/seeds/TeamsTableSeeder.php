<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Team::class, 1)->create()->each(function ($u) {
            $u->players()->save(factory(App\Player::class)->make());
        });
    }
}
