<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'subject',
        'description',
        'user_id',
        'assign_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
