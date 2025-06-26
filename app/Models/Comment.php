<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasUuids;
    protected $fillable = [
        'content',
        'commentable_type',
        'commentable_id',
        'user_id',
    ];
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
