<?php
namespace Tests;

use App\Models\Book;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;


class BookTest extends TestCase
{
    use DatabaseTransactions;
    protected $blueprint = "books";

    public function testIndex()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        Book::factory()->count(3)->create();

        $response = $this->get("/books", [
            'Authorization' => "Bearer $token"
        ]);


        $response->seeStatusCode(200);
    }

    public function testDetail()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();

        $response = $this->get("/books/{$book->id}", [
            'Authorization' => "Bearer $token"
        ]);

        $response->seeStatusCode(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->make()->toArray();

        $response = $this->post("/books", $book, [
            "Authorization" => "Bearer $token",
            'Accept' => 'application/json'
        ]);
        $response->seeStatusCode(201);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();
        $updateData = ['title' => 'Update Title'];

        $response = $this->patch("/books/{$book->id}", $updateData, [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ]);
        $response->seeStatusCode(200);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();

        $response = $this->delete("/books/{$book->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testGetTrash()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();
        $book->delete();

        $response = $this->get("/books/trash", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
    }

    public function testRestore()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();
        $book->delete();

        $response = $this->get("/books/restore/{$book->id}", [
            'Authorization' => "Bearer $token"
        ]);
        $response->seeStatusCode(200);
        $this->assertNotNull(Book::find($book->id));
    }

    public function testForceDelete()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $book = Book::factory()->create();
        $book->delete();

        $response = $this->delete("/books/delete/{$book->id}", [
            'Authorization' => "Bearer $token"
        ]);

        $response->seeStatusCode(200);
        $this->assertNull(Book::withTrashed()->find($book->id));
    }
}
