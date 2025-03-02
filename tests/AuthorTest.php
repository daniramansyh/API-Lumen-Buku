<?php
namespace Tests;

use Tests\TestCase;
use App\Models\Author;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;
    protected $blueprint = "authors";

    public function testIndex()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        Author::factory()->count(3)->create();

        $response = $this->get("/authors", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testDetail()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $author = Author::factory()->create();

        $response = $this->get("/authors/{$author->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user); 
        $author = Author::factory()->make()->toArray();
    
        $response = $this->post("/authors", $author, [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ]);
        $response->seeStatusCode(201);
    }
    

    public function testUpdate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user); 
        $author = Author::factory()->create();
        $updateData = ['name' => 'Updated Name'];

        $response = $this->patch("/authors/{$author->id}", $updateData, [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ]);
        $response->seeStatusCode(200);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $token = auth()->login($user); 
        $author = Author::factory()->create();

        $response = $this->delete("/authors/{$author->id}", [
            'Authorization' => "Bearer $token",
        ]);
        $response->seeStatusCode(200);
    }
}
