<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create();
        factory(App\Event::class, 10)->create();
        factory(App\Photo::class, 10)->create();
        factory(App\Favorite::class, 10)->create();
    }
}
