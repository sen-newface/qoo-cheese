<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase; //マイグレーションが実行されテーブルが作成される

    public function testShow()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $event1 = $user->events()->save(
            factory(\App\Event::class)->make(
                [
                'user_id' => $user->id,
                ]
            )
        );

        $res = $this->actingAs($user)->json('get', 'api/events/' . $event1->id);
        $res->assertJsonStructure(
            [
            'id',
            'name',
            'start_date',
            'end_date',
            'photos',
            ]
        );
        $res->assertStatus(200);
    }

    public function testShowNotLogin()
    {
        $user = factory(User::class)->create();
        $event1 = $user->events()->save(
            factory(\App\Event::class)->make(
                [
                'user_id' => $user->id,
                ]
            )
        );
        $res = $this->json('get', 'api/events/' . $event1->id . '?key=' . $event1->key);
        $res->assertJsonStructure(
            [
            'id',
            'name',
            'start_date',
            'end_date',
            'photos',
            ]
        );
    }

    public function testIndex()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        for ($i = 1; $i <= 3; $i++) {
            $user->events()->save(
                factory(\App\Event::class)->make(
                    [
                    'user_id' => $user->id,
                    ]
                )
            );
        }

        $user2->events()->save(
            factory(\App\Event::class)->make(
                [
                'user_id' => $user2->id,
                ]
            )
        );

        $res = $this->actingAs($user)->json('get', 'api/events');
        $res->assertJsonStructure(
            [
                'data' => [
                '*' => [
                'id',
                'key',
                'name',
                'start_date',
                'end_date',
                'photos' => [
                    '*' => [
                    ' id',
                      'image_path'
                    ]
                  ]
                 ]
               ]
             ]
        );
        $res->assertJsonCount(3, 'data');
        $res->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
        'name' => 'test',
        'start_date' => '2020-11-11',
        'end_date' => '2020-12-12',
        ];
        $user = factory(User::class)->create();
        $res = $this->actingAs($user)->json('POST', 'api/events', $data);
        $res->assertJsonStructure(
            [
            'id',
            'name',
            'start_date',
            'end_date',
            'photos',
            ]
        );
        $res->assertStatus(201);
    }
}
