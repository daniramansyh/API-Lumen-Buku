<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;
use Illuminate\Support\Str;

class ResourceCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        if (! $resource->isEmpty()) {
            $this->collects = Str::replaceFirst('App\Models', 'App\Http\Resources', get_class($resource->first()));
        }

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
