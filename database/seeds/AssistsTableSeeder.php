<?php

use Illuminate\Database\Seeder;

class AssistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Assist::class, 50)->create()->each(function ($u) {
            $u->match()->associate(factory(App\Match::class)->make()->save())->save();
            $u->team()->associate(factory(App\Team::class)->make()->save())->save();
            $u->player()->associate(factory(App\Player::class)->make()->save())->save();
            $u->goal()->associate(factory(App\Goal::class)->make()->save())->save();
        });

    }
}
