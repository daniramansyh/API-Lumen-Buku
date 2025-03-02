<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Author extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "region" => $this->region,
            "birth_date" => $this->birth_date,
            "death_date" => $this->death_date,
            "education" => $this->education,
            "awards" => $this->awards,
            "writing_style" => $this->writing_style,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
