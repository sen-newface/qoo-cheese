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

    public $user;
    public $user2;
    public $event;

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->actingAs($user);
        $event = factory(Event::class)->create(
            [
            'user_id' => $user->id
            ]
        );
        $this->event = $event;
        $this->user = $user;
        $this->user2 = $user2;
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

        $url = route('events.photos.index', ['event' => $this->event->id]);
        $res = $this->json('get', $url);
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
        $file2 = UploadedFile::fake()->image('test.jpeg');
        $url = route('events.photos.store', $this->event->id);
        $data = [
        'event_id' => $this->event->id,
        'images' => [$file, $file2],
        ];
        $response = $this->post($url, $data);
        Storage::disk('images')->exists($file->name);
        $response
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure(
                [
                '*' => [
                'id',
                'image_path',
                'title'
                ]
                ]
            );
    }

    public function testStore403()
    {
        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $file2 = UploadedFile::fake()->image('test.jpeg');
        $url = route('events.photos.store', $this->event->id);
        $data = [
        'event_id' => $this->event->id,
        'images' => [$file, $file2],
        ];
        $this->actingAs($this->user2);
        $response = $this->post($url, $data);
        Storage::disk('images')->exists($file->name);
        $response
        ->assertStatus(403);
    }

    /**
     * @test
     */
    public function testDestroy()
    {
        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $url = route('events.photos.store', ['event' => $this->event->id]);
        $data = [
        'event_id' => $this->event->id,
        'images' => [$file],
        ];
        $response = $this->post($url, $data);
        $url = route('events.photos.destroy', ['event' => $this->event->id, 'photo' => $response[0]["id"]]);
        $response = $this->delete($url, [$this->event, $response[0]["id"]]);
        $response
        ->assertStatus(204);
    }

    /**
     * @test
     */
    public function testInvalidDestroy()
    {
        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $url = route('events.photos.store', ['event' => $this->event->id]);
        $data = [
            'event_id' => $this->event->id,
            'image_path' => $file,
        ];
        $response = $this->post($url, $data);
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $url = route('events.photos.destroy', ['event' => $this->event->id, 'photo' => $response['id']]);
        $response = $this->delete($url, [$this->event, $response['id']]);
        $response
            ->assertStatus(403);
    }
}
