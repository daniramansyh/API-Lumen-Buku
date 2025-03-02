<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Publisher extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "founded_year" => $this->founded_year,
            "founder" => $this->founder,
            "headquarters" => $this->headquarters,
            "website" => $this->website,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
