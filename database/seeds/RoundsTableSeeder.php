<?php

use Illuminate\Database\Seeder;

class RoundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Round::class, 50)->create()->each(function ($u) {
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
            $u->matches()->save(factory(App\Match::class)->make());
        });
    }
}
