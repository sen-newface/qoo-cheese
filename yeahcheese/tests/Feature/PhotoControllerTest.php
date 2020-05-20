<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Event;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoControllerTest extends TestCase
{
    use RefreshDatabase;

    public $user, $event;

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();

        $this->actingAs($user);
        $event = factory(Event::class)->create(
            [
                'user_id' => $user->id
            ]
        );
        $this->event = $event;
        $this->user = $user;
    }

    public function testIndex()
    {
        $event2 = $this->user->events()->save(
            factory(\App\Event::class)->make(
                [
                'user_id' => $this->user->id,
                ]
            )
        );

        for ($i = 1; $i <= 3; $i++) {
            $this->event->photos()->save(
                factory(\App\Photo::class)->make(
                    [
                    'event_id' => $this->event->id,
                    ]
                )
            );
        }

        $event2->photos()->save(
            factory(\App\Photo::class)->make(
                [
                'event_id' => $event2->id,
                ]
            )
        );

        $res = $this->json('get', 'api/events/' . $this->event->id . '/photos');
        $res->assertJsonCount(3);
        $res->assertJsonStructure(
            [
            '*' => [
            'id',
            'image_path'
            ]
            ]
        );
        $res->assertStatus(200);
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
            ->assertJsonStructure(
                [
                    'id',
                    'image_path'
                ]
            );
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
        $url .= '/' . $response['id'];
        $response = $this->delete($url, [$this->event, $response['id']]);
        $response
        ->assertStatus(204);
    }
}
