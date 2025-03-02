<?php
namespace Tests;

use App\Models\Publisher;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;


class PublisherTest extends TestCase
{
    use DatabaseTransactions;
    protected $blueprint = "publishers";

    public function testIndex()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        Publisher::factory()->count(3)->create();

        $response = $this->get('/publishers', [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertResponseStatus(200);
    }

    public function testDetail()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $publisher = Publisher::factory()->create();

        $response = $this->get("/publishers/{$publisher->id}", [
            'Authorization' => "Besrer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $publisher = Publisher::factory()->create()->toArray();

        $response = $this->post('/publishers', $publisher, [
            'Authorization'=> "Bearer $token"
        ]);
        $response->assertResponseStatus(201);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $publisher = Publisher::factory()->create();
        $updateData = ['name' => 'Updated Name'];

        $response = $this->patch("/publishers/{$publisher->id}", $updateData, [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $publisher = Publisher::factory()->create();

        $response = $this->delete("/publishers/{$publisher->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }
}
