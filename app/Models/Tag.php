<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'article_id',
    ];
    public function article(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
