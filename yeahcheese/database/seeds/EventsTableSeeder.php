<?php

use Illuminate\Database\Seeder;
use App\Event;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //一括削除
        Event::truncate();

        $faker = Faker::create('ja_JP');

        for($i = 0; $i < 10; $i++){
            $start_date = $faker->date($format='Y-m-d',$max='now');
            Event::create([
                'name' => $faker->name,
                'start_date' => $start_date,
                'end_date' => $faker->date($format='Y-m-d', $min=$start_date, $max='now'),
                'user_id' => $faker->regexify('[1-3]{1}')
            ]);
        }
    }
}
