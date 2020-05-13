<?php

use Illuminate\Database\Seeder;
use App\Photo;
use Faker\Factory as Faker;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //一括削除
        Photo::truncate();

        $faker = Faker::create('ja_JP');

        for($i = 0; $i < 10; $i++){
            Photo::create([
                'image_path' => $faker->url,
                'event_id' => $faker->numberBetween(1, 10)
            ]);
        }
    }
}
