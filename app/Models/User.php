<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    protected $table = 'users';

    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createdBoards(): HasMany
    {
        return $this->hasMany(Board::class, 'user_id', 'id');
    }

    public function boardUsers(): HasMany
    {
        return $this->hasMany(BoardUser::class, 'user_id', 'id');
    }

    public function boards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class)->using(BoardUser::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignment', 'id');
    }

    public function createdBoardsTasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Board::class, 'user_id', 'board_id', 'id', 'id');
    }
}
