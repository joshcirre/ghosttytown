<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Config extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function starredBy()
    {
        return $this->belongsToMany(User::class, 'config_star')
            ->withTimestamps();
    }

    public function getStarsCountAttribute()
    {
        return $this->starredBy()->count();
    }

    public function isStarredBy(User $user)
    {
        return $this->starredBy()->where('user_id', $user->id)->exists();
    }
}
