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
            $u->season()->associate(factory(App\Season::class)->make()->save())->save();
            $u->players()->save(factory(App\Player::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
        });
    }
}
