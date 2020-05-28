<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use App\Photo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase; //マイグレーションが実行されテーブルが作成される

    public function testShow()
    {
        $user = factory(User::class)->create();
        $event1 = $user->events()->save(
            factory(\App\Event::class)->make(
                [
                    'user_id' => $user->id,
                ]
            )
        );

        $url = route('events.show', ['event' => $event1->id]);
        $res = $this->actingAs($user)->json('get', $url);
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

        $url = route('events.show', ['event' => $event1->id]) . '?key=' . $event1->key;
        $res = $this->json('get', $url);
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

        $url = route('events.index');
        $res = $this->actingAs($user)->json('get', $url);
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
                                'id',
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

        $url = route('events.store');
        $res = $this->actingAs($user)->json('POST', $url, $data);
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

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create([
            'user_id' => $user->id
        ]);

        $event_id = $event->id;
        $event->name = '更新したイベント名';
        $event->start_date = '2020-09-21';
        $event->end_date = '2020-10-21';
        $event = $event->toArray();

        $url = route('events.update', ['event' => $event_id]);
        $response = $this->actingAs($user)->put($url, $event);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'start_date',
                'end_date',
                'user_id',
                'key',
                'id',
                'photos'
            ]);
    }

    public function testDestory()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id]);
        factory(Photo::class)->create(['event_id' => $event->id]);

        $url = route('events.destroy', ['event' => $event->id]);
        $res = $this->actingAs($user)->json("DELETE", $url);
        $res->assertStatus(204);
        $this->assertEquals(0, count($user->events));
        $this->assertEquals(0, count(\App\Photo::all()));
    }

    /**
     * 異常系: ログインしていなければ弾く
     */
    public function testShowLoginError()
    {
        $user = factory(User::class)->create();
        $event1 = $user->events()->save(
            factory(\App\Event::class)->make(
                [
                    'user_id' => $user->id,
                ]
            )
        );

        $url = route('events.show', ['event' => $event1->id]);
        $res = $this->json('get', $url);
        $res->assertStatus(403);
    }

    /**
     * 異常系: ログインしていてイベントが見つからなかった時
     */
    public function testShowError()
    {
        $user = factory(User::class)->create();

        $url = route('events.show', ['event' => "test"]);
        $res = $this->actingAs($user)->json('get', $url);
        $res->assertStatus(404);
    }

    /**
     * 異常系: ゲストでイベントが見つからなかった時
     */
    public function testShowNotLoginError()
    {
        $user = factory(User::class)->create();
        $event1 = $user->events()->save(
            factory(\App\Event::class)->make(
                [
                    'user_id' => $user->id,
                ]
            )
        );

        $url = route('events.show', ['event' => $event1->id]) . '?key=' . "test";
        $res = $this->json('get', $url);
        $res->assertStatus(403);
    }

    /**
     * 異常系: イベント作成のバリデーションエラー
     */
    public function testStoreError()
    {
        // nameがnull
        $data1 = [
            'name' => '',
            'start_date' => '2120-11-11',
            'end_date' => '2120-12-12',
        ];
        // start_dateがnull
        $data2 = [
            'name' => 'test',
            'start_date' => '',
            'end_date' => '2120-12-12',
        ];

        // start_dateが今日より前
        $data3 = [
            'name' => 'test',
            'start_date' => '2010-10-10',
            'end_date' => '2120-12-12',
        ];

        // start_dateがend_dateより後
        $data4 = [
            'name' => 'test',
            'start_date' => '2130-10-10',
            'end_date' => '2120-12-12',
        ];
        // end_dateがnull
        $data5 = [
            'name' => 'test',
            'start_date' => '2120-11-11',
            'end_date' => '',
        ];
        $user = factory(User::class)->create();

        $url = route('events.store');
        $res = $this->actingAs($user)->json('POST', $url, $data1);
        $res->assertStatus(422);
        $res = $this->actingAs($user)->json('POST', $url, $data2);
        $res->assertStatus(422);
        $res = $this->actingAs($user)->json('POST', $url, $data3);
        $res->assertStatus(422);
        $res = $this->actingAs($user)->json('POST', $url, $data4);
        $res->assertStatus(422);
        $res = $this->actingAs($user)->json('POST', $url, $data5);
        $res->assertStatus(422);
    }

    /**
     * 異常系: イベント更新のバリデーションエラー
     */
    public function testUpdateError()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create([
            'user_id' => $user->id
        ]);

        // nameがnull
        $event_id = $event->id;
        $event->name = '';
        $event->start_date = '2020-09-21';
        $event->end_date = '2020-10-21';
        $data = $event->toArray();

        $url = route('events.update', ['event' => $event_id]);
        $response = $this->actingAs($user)->put($url, $data);
        $response->assertStatus(302);

        // start_dateがnull
        $event->name = '更新したイベント名';
        $event->start_date = '';
        $event->end_date = '2100-10-21';
        $data = $event->toArray();

        $url = route('events.update', ['event' => $event_id]);
        $response = $this->actingAs($user)->put($url, $data);
        $response->assertStatus(302);

        // start_dateがend_dateより後ろ
        $event->name = '更新したイベント名';
        $event->start_date = '2122-2-22';
        $event->end_date = '2120-10-21';
        $data = $event->toArray();

        $url = route('events.update', ['event' => $event_id]);
        $response = $this->actingAs($user)->put($url, $data);
        $response->assertStatus(302);

        // end_dateがnull
        $event->name = '更新したイベント名';
        $event->start_date = '2120-09-21';
        $event->end_date = '';
        $data = $event->toArray();

        $url = route('events.update', ['event' => $event_id]);
        $response = $this->actingAs($user)->put($url, $data);
        $response->assertStatus(302);
    }

    /**
     * 異常系: イベント削除のエラー
     */
    public function testDestoryError()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id]);
        factory(Photo::class)->create(['event_id' => $event->id]);

        $url = route('events.destroy', ['event' => "test"]);
        $res = $this->actingAs($user)->json("DELETE", $url);
        $res->assertStatus(404);
        $this->assertEquals(1, count($user->events));
        $this->assertEquals(1, count(\App\Photo::all()));
    }
}
