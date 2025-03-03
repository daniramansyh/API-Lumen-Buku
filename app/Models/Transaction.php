<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'transactions';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'book_id',
        'user_id',
        'borrow_date',
        'return_date',
        'status',
    ];

    public const BORROWED = 'borrowed';
    public const RETURNED = 'returned';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
