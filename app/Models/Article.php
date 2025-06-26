<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory, HasUuids;
    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
    ];
    protected $appends = [
        'is_liked',
        'likes_count'
    ];
    protected $with = ['likedBy'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
    public function tag(string $name): void
    {
        $tag = Tag::firstOrCreate(['name' => $name]);
        if (!$this->tags->contains($tag)) {
            $this->tags()->attach($tag);
        }
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_likes');
    }
    public function getIsLikedAttribute(): bool
    {
        return Auth::check() && $this->likedBy->contains(Auth::id());
    }
    public function getLikesCountAttribute() : int
    {
        return $this->likedBy()->count();
    }
}
