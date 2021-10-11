<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmailConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'valid'
    ];

    public function document(): HasOne
    {
        return $this
            ->hasOne(
                User::class,
                'id',
                'user_id'
            );
    }
}
