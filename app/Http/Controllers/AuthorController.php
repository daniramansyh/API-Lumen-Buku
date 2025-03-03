<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class AuthorController extends Controller
{
    public function index()
    {
        try {
            $authors = Author::all();
            return $this->respondResource($authors);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        try {
            $author = Author::findOrFail($id);
            return $this->respondResource($author);
        } catch (\Exception) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }

    public function create()
    {
        try {
            $author = new Author();
            $author->id = Uuid::uuid4()->toString();
            $author = $this->fill($author, $this->request->only(
                'name',
                'region',
                'birth_date',
                'death_date',
                'education',
                'awards',
                'writing_style',
            ));
            $author->save();
            return $this->respondResource($author);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author = $this->fill($author, $this->request->only(
                'name',
                'region',
                'birth_date',
                'death_date',
                'education',
                'awards',
                'writing_style',
            ));
            $author->save();
            return $this->respondResource($author);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();
            return $this->respondMessage('done!');
        } catch (\Exception $e) {
            return response()->json(['error' => "data not found !"], 500);
        }
    }

    private function fill(Author $author, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $author->{$key} = $value;
        }

        Validator::make($author->toArray(), [
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date',
            'education' => 'nullable|string',
            'awards' => 'nullable|string',
            'writing_style' => 'nullable|string',
        ])->validate();

        $author->save();

        return $author;
    }
}
