<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event = new \App\Event([
            'name' => '千入学式',
            'start_date' => '2019-04-06',
            'end_date' => '2019-04-06',
            'user_id' => '2',
        ]);
        $event->save();

        $event = new \App\Event([
            'name' => '千夏休み',
            'start_date' => '2019-07-06',
            'end_date' => '2019-08-06',
            'user_id' => '1',
        ]);
        $event->save();

        $event = new \App\Event([
            'name' => '千冬休み',
            'start_date' => '2019-12-24',
            'end_date' => '2020-01-06',
            'user_id' => '3',
        ]);
        $event->save();

        $event = new \App\Event([
            'name' => '千梅雨入り',
            'start_date' => '2019-06-06',
            'end_date' => '2020-06-26',
            'user_id' => '3',
        ]);
        $event->save();

        $event = new \App\Event([
            'name' => '千BBQ',
            'start_date' => '2019-08-08',
            'end_date' => '2020-08-08',
            'user_id' => '1',
        ]);
        $event->save();
    }
}
