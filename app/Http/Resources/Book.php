<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "author" => $this->author,
            "publisher" => $this->publisher,
            "publication_year" => $this->publication_year,
            "isbn" => $this->isbn,
            "genre" => $this->genre,
            "pages" => $this->pages,
            "language" => $this->language,
            "edition" => $this->edition,
            "synopsis" => $this->synopsis,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
