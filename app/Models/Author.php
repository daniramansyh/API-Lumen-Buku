<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'authors';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'region',
        'birth_date',
        'death_date',
        'education',
        'awards',
        'writing_style',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
