<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResourceCollection;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $request;

    protected $statusCode = Response::HTTP_OK;

    protected $headers = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    public function respond($data)
    {
        return response()->json($data, $this->getStatusCode(), $this->getHeaders());
    }

    public function respondMessage(string $message)
    {
        return response()->json(['message' => $message], $this->getStatusCode(), $this->getHeaders());
    }

    public function respondError($message, $errors = [])
    {
        if ($this->getStatusCode() >= 200 && $this->getStatusCode() < 300) {
            throw new Exception('An error with 2xx status code. Really, mate?');
        }

        return $this->respond([
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    public function respondResource($resource)
    {
        if ($this->isCollectionOrPaginator($resource)) {
            return new ResourceCollection($resource);
        }

        $transformer = Str::replaceFirst('App\Models', 'App\Http\Resources', get_class($resource));

        return new $transformer($resource);
    }

    protected function perPage($default = 20)
    {
        $perPage = (int) $this->request->input('per_page');

        // per_page max is 100. for no apparent reason
        return $perPage > 0 && $perPage <= 100 ?
            $perPage : $default;
    }

    private function isCollectionOrPaginator($resource)
    {
        return $resource instanceof Collection ||
            $resource instanceof EloquentCollection ||
            $resource instanceof AbstractPaginator;
    }
}
