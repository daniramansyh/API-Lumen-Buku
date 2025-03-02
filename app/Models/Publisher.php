<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = "publishers";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'founded_year' => 'integer',
    ];

    protected $fillable = [
        'name',
        'founded_year',
        'location',
        'website',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
