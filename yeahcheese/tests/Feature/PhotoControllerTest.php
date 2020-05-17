<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Event;
use App\Photo;
use Carbon\Carbon;

class PhotoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testStore()
    {

        factory(User::class, 10)->create();
        factory(Event::class, 50)->create();

        $postTime = Carbon::now();

        $photos = [
            'id' => 1,
            'image_path' => 'djsijiajdis.jpeg',
            'event_id' => 10,
            'created_at' => $postTime,
            'updated_at' => $postTime
        ];

        $url = '/api/events/' . $photos['event_id'] . '/photos';

        $response = $this->post($url, $photos);

        $response
            ->assertOk()
            ->assertJsonCount(5)
            ->assertJsonFragment([
                'id' => 1,
                'image_path' => 'djsijiajdis.jpeg',
                'event_id' => 10,
            ]);
    }

    public function testDestroy()
    {

        $deleteTime = Carbon::now();

        factory(User::class, 10)->create();
        $user = User::first();
        $event = new Event();
        $event->id = 100;
        $event->name = '運動会';
        $event->key = 'test-key';
        $event->start_date = $deleteTime;
        $event->end_date = $deleteTime;
        $event->user_id = $user->id;
        $event->created_at = $deleteTime;
        $event->updated_at = $deleteTime;

        $url = '/api/events/' . $event->id;

        $response = $this->delete($url, [$event->id]);

        $response
            ->assertOk();
        
    }

}
