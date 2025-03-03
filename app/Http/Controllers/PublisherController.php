<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PublisherController extends Controller
{
    public function index()
    {
        try {
            $publishers = Publisher::all();
            return $this->respondResource($publishers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        try {
            $publisher = Publisher::findOrFail($id);
            return $this->respondResource($publisher);
        } catch (\Exception $e) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }

    public function create()
    {
        try {
            $publisher = new Publisher();
            $publisher->id = Uuid::uuid4()->toString();
            $publisher = $this->fill($publisher, $this->request->only(
                'name',
                'founded_year',
                'founder',
                'headquarters',
                'website',
            ));
            $publisher->save();
            return $this->respondResource($publisher);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id)
    {
        try {
            $publisher = Publisher::findOrFail($id);
            $publisher = $this->fill($publisher, $this->request->only(
                'name',
                'founded_year',
                'founder',
                'headquarters',
                'website',
            ));
            $publisher->save();
            return $this->respondResource($publisher);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $publisher = Publisher::findOrFail($id);
            $publisher->delete();
            return $this->respondMessage('done!');
        } catch (\Exception $e) {
            return response()->json(['error' => "data not found !"], 404);
        }
    }

    private function fill(Publisher $publisher, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $publisher->{$key} = $value;
        }

        Validator::make($publisher->toArray(), [
            'name' => 'required|string|max:255',
            'founded_year' => 'nullable|integer',
            'founder' => 'nullable|string',
            'headquarters' => 'nullable|string',
            'website' => 'nullable|string',
        ])->validate();

        $publisher->save();

        return $publisher;
    }
}
