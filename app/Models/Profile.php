<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasUuids;
    protected $fillable = [
        'username',
        'bio',
        'country',
        'city',
        'phone',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
