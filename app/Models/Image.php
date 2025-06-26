<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'path',
        'imageable_type',
        'imageable_id',
    ];
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
