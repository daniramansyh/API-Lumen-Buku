<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class GenreController extends Controller
{
    public function index()
    {
        try {
            $genres = Genre::all();
            return $this->respondResource($genres);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            return $this->respondResource($genre);
        } catch (\Exception $e) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }

    public function create()
    {
        try {
            $genre = new Genre();
            $genre->id = Uuid::uuid4()->toString();
            $genre = $this->fill($genre, $this->request->only('name', ));
            $genre->save();
            return $this->respondResource($genre);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre = $this->fill($genre, $this->request->only('name', ));
            $genre->save();
            return $this->respondResource($genre);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();
            return $this->respondMessage('done!');
        } catch (\Exception $e) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }

    private function fill(Genre $genre, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $genre->{$key} = $value;
        }

        Validator::make($genre->toArray(), [
            'name' => 'required|string|max:255',
        ])->validate();

        $genre->save();

        return $genre;
    }
}
