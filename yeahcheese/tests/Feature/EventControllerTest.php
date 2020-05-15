<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class EventsTest extends TestCase
{
    use RefreshDatabase; //マイグレーションが実行されテーブルが作成される

    public function testStore(){
        $data = [
            'name' => 'test',
            'start_date' => '2019-11-11',
            'end_date' => '2019-12-12',
        ];
        $user = factory(User::class)->create();
        $res = $this->actingAs($user)->json('POST', 'api/events', $data);
        $res->assertStatus(201);
    }
}
