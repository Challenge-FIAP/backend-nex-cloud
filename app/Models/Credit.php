<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeric_score',
        'alphabetical_score',
        'presumed_income'
    ];

    public function user(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                'id'
            );
    }
}
