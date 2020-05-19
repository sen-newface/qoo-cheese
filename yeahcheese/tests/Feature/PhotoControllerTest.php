<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use App\Photo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoControllerTest extends TestCase
{
  use RefreshDatabase; //マイグレーションが実行されテーブルが作成される

  public function testIndex()
  {
    $user = factory(User::class)->create();
    $event = $user->events()->save(factory(\App\Event::class)->make([
      'user_id' => $user->id,
    ]));

    $event2 = $user->events()->save(factory(\App\Event::class)->make([
      'user_id' => $user->id,
    ]));

    for ($i = 1; $i <= 3; $i++) {
      $event->photos()->save(factory(\App\Photo::class)->make([
        'event_id' => $event->id,
      ]));
    }

    $event2->photos()->save(factory(\App\Photo::class)->make([
      'event_id' => $event2->id,
    ]));
    // $event2->photos()->save(factory(\App\Photo::class)->make([
    //   'event_id' => $event2->id,
    // ]));

    $res = $this->json('get', 'api/events/' . $event->id . '/photos');
    $res->assertJsonCount(3);
    $res->assertJsonStructure([
      '*' => [
        'id',
        'image_path'
      ]
    ]);
    $res->assertStatus(200);
  }
}
