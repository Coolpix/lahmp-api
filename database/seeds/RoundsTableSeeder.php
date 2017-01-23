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
        factory(App\Round::class, 100)->create()->each(function ($u) {
            $u->season()->associate(factory(App\Season::class)->make()->save())->save();
            $u->matches()->save(factory(App\Match::class)->make());
        });
    }
}
