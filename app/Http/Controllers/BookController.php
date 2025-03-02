<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class BookController extends Controller
{
    public function index()
    {
        try {
            $books = Book::all();
            return $this->respondResource($books);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        try {
            $book = Book::findOrFail($id);
            return $this->respondResource($book);
        } catch (\Exception) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }
    public function create()
    {
        try {
            $book = new Book();
            $book->id = Uuid::uuid4()->toString();
            $book = $this->fill($book, $this->request->only(
                "title",
                "author_id",
                "publisher_id",
                "publication_year",
                "isbn",
                "genre_id",
                "pages",
                "language",
                "edition",
                "synopsis",
            ));

            return $this->respondResource($book);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book = $this->fill($book, $this->request->only(
                "title",
                "author_id",
                "publisher_id",
                "publication_year",
                "isbn",
                "genre_id",
                "pages",
                "language",
                "edition",
                "synopsis",
            ));
            return $this->respondResource($book);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return $this->respondMessage('done!');
        } catch (\Exception) {
            return response()->json(['error' => "data not found !"], 500);
        }
    }

    public function getTrash()
    {
        try {
            $books = Book::onlyTrashed()->get();
            return $this->respondResource($books);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $book = Book::onlyTrashed()->findOrFail($id);
            $book->restore();
            return $this->respondResource($book);
        } catch (\Exception) {
            return response()->json(['error' => "data not found !"], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            $book = Book::onlyTrashed()->findOrFail($id);
            $book->forceDelete();
            return $this->respondMessage('done!');
        } catch (\Exception) {
            return response()->json(['error' => "data not found !"], 500);
        }
    }

    private function fill(Book $book, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $book->{$key} = $value;
        }

        Validator::make($book->toArray(), [
            'title' => 'required|string',
            'author_id' => 'required|string',
            'publisher_id' => 'required|string',
            'publication_year' => 'required|integer',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'genre_id' => 'required|string',
            'pages' => 'required|integer',
            'language' => 'required|string',
            'edition' => 'nullable|string',
            'synopsis' => 'nullable|string',
        ])->validate();

        $book->save();

        return $book;
    }
}
