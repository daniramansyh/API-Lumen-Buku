<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = "books";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['status'] ;
    public const AVAILABLE = 'available';
    public const NOT_AVAILABLE = 'not_available';

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
