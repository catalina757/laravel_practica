<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BoardUser extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'board_users';

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
