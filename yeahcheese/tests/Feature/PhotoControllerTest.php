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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoControllerTest extends TestCase
{
    use RefreshDatabase;

    public $event;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User();
        $user->name = 'TEST';
        $user->email = 'test@gmail.com';
        $user->password = 'TESTTESTTEST';
        $user->save();

        $this->actingAs($user);

        $event = new Event();
        $event->name = 'XXX';
        $event->key = 'XYZOPQRSTU';
        $event->start_date = '2020-09-21';
        $event->end_date = '2020-10-21';
        $event->user_id = $user->id;
        $event->save();

        $this->event = $event;
    }

    /**
     * @test
     */
    public function testStore()
    {
        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $url = '/api/events/' . $this->event->id . '/photos';
        $data = [
            'event_id' => $this->event->id,
            'image_path' => $file,
        ];
        $response = $this->post($url, $data);
        Storage::disk('images')->exists($file->name);
        $response
            ->assertStatus(201)
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'status' => 201,
            ]);
    }

    /**
     * @test
     */
    public function testDestroy()
    {
        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $url = '/api/events/' . $this->event->id . '/photos';
        $data = [
            'event_id' => $this->event->id,
            'image_path' => $file,
        ];
        $url = '/api/events/' . $this->event->id . '/photos';
        $response = $this->post($url, $data);
        $photo = $response['data'];
        $url .= '/' . $photo['id'];
        $response = $this->delete($url, [$this->event, $photo['id']]);
        $response
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'status' => 204
            ]);
    }

}
