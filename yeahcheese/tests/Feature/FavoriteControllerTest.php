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

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    public $event;
    public $photo;

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

        Storage::fake('images');
        $file = UploadedFile::fake()->image('test.jpeg');
        $photo = factory(Photo::class)->create(
            [
                'image_path' => $file,
                'event_id' => $event->id
            ]
        );
        $this->photo = $photo;
        $this->event = $event;
        $this->user = $user;
    }

    public function testIndex()
    {
        $url = route('like.store');
        $data = [
            'user_id' => $this->user->id,
            'photo_id' => $this->photo->id,
        ];
        $this->post($url, $data);

        $url = route('like.index');
        $res = $this->json('get', $url);
        $res->assertJsonCount(1);
        $res->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'image_path',
                    'is_favorite'
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
        $url = route('like.store');
        $data = [
            'user_id' => $this->user->id,
            'photo_id' => $this->photo->id,
        ];
        $response = $this->post($url, $data);
        $response
            ->assertStatus(201);
        $this->assertEquals(1, count($this->user->photos));
    }

    /**
     * @test
     */
    public function testDestroy(){
        $url = route('like.store');
        $data = [
            'photo_id' => $this->photo->id,
        ];
        $response = $this->post($url, $data);
        $url = route('like.destroy');
        $response = $this->delete($url, ['photo_id' => $this->photo->id]);
        $response->assertStatus(204);
        $this->assertEquals(0, count($this->user->photos));
    }

    /**
     * 異常系
     */
    public function testDestroyError()
    {
        $this->actingAs($this->user);
        $url = route('like.store');
        $data = [
            'photo_id' => $this->photo->id,
        ];
        $response = $this->post($url, $data);
        $url = route('like.destroy');
        $response = $this->delete($url, ['photo_id' => null]);
        $response
            ->assertStatus(200);
        $this->assertEquals(1, count($this->user->photos));
    }

    /**
     * 異常系: ログインしてなければ弾く
     */
    public function testIndexError()
    {
        $url = route('like.store');
        $data = [
            'photo_id' => $this->photo->id,
        ];
        $this->post($url, $data);
        $url = route('like.index');
        $res = $this->json('get', $url);
        if ($res->assertStatus(401)) {
            return;
        }
        $res->assertJsonCount(1);
        $res->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'image_path',
                    'is_favorite'
                ]
            ]
        );
        $res->assertStatus(200);
    }
}
