<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "book" => $this->book,
            "user" => $this->user,
            "borrow_date" => $this->borrow_date,
            "return_date" => $this->return_date,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
