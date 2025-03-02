<?php
namespace Tests;

use Tests\TestCase;
use App\Models\Genre;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GenreTest extends TestCase
{
    use DatabaseTransactions;
    protected $blueprint = "genres";

    public function testIndex()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        Genre::factory()->count(3)->create();

        $response = $this->get('/genres', [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testDetail()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $author = Genre::factory()->create();

        $response = $this->get("/genres/{$author->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $genre = Genre::factory()->create()->toArray();

        $response = $this->post('/genres', $genre, [
            'Authorization'=> "Bearer $token"
        ]);
        $response->seeStatusCode(201);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $author = Genre::factory()->create();
        $updateData = ['name' => 'Action'];

        $response = $this->patch("/genres/{$author->id}", $updateData, [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $author = Genre::factory()->create();

        $response = $this->delete("/genres/{$author->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }
}
