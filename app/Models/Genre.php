<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = "genres";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
