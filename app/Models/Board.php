<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function boardUsers():HasMany
    {
        return $this->hasMany(BoardUser::class, 'board_id', 'id');
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(BoardUser::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'board_id', 'id');
    }
}
