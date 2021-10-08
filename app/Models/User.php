<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'uid',
        'date_accept_terms',
        'social_name',
        'name',
        'email',
        'birth_date',
        'mother_name',
        'marital_status',
        'education_level',
        'password',
        'document_id',
        'address_id',
        'credit_id',
    ];

    protected $hidden = [
        'password',
        'document_id',
        'address_id',
        'credit_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function document(): HasOne
    {
        return $this
            ->hasOne(
                Document::class,
                'id',
                'document_id'
            );
    }

    public function credit(): HasOne
    {
        return $this
            ->hasOne(
                Credit::class,
                'id',
                'credit_id'
            );
    }

    public function address(): HasOne
    {
        return $this
            ->hasOne(
                Address::class,
                'id',
                'address_id'
            );
    }
}
