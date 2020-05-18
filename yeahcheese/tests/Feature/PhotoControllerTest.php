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

    public $commonTime;
    public $storePhoto;
    public $photo;
    public $event;

    public function setUp(): void
    {
        parent::setUp();

        $this->commonTime = Carbon::now();

        $user = new User();
        $user->name = 'test';
        $user->email = 'test@gmail.com';
        $user->password = 'testtest';
        $user->save();

        $event = new Event();
        $event->id = 999;
        $event->name = '運動会';
        $event->key = 'oooooiiiiiii';
        $event->start_date = $this->commonTime;
        $event->end_date = $this->commonTime;
        $event->user_id = $user->id;
        $event->save();

        $this->event = $event;

        $this->storePhoto = [
            'id' => 2,
            'image_path' => 'djsijiajdis.jpeg',
            'event_id' => 999,
            'created_at' => $this->commonTime,
            'updated_at' => $this->commonTime
        ];

        $this->photo = new Photo($this->storePhoto);
        $this->photo->save();
    }

    public function testStore()
    {
        $url = '/api/events/' . $this->photo->event_id . '/photos';

        $response = $this->post($url, $this->storePhoto);

        $response
            ->assertOk()
            ->assertJsonCount(5)
            ->assertJsonFragment([
                'id' => 2,
                'image_path' => 'djsijiajdis.jpeg',
                'event_id' => 999,
            ]);
    }

    public function testDestroy()
    {
        $deletePhoto = [
            'id' => 3,
            'image_path' => 'djsijiajdis.jpeg',
            'event_id' => 999,
            'created_at' => $this->commonTime,
            'updated_at' => $this->commonTime
        ];
        $photo = new Photo($deletePhoto);
        $url = '/api/events/' . $this->event->id . '/photos' . '/' . $deletePhoto['id'];
        $response = $this->delete($url, [$this->event, $photo]);
        $response
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'status' => 204
            ]);
    }

}
