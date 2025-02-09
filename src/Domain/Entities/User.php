<?php

namespace ChatApp\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['id', 'username', 'auth_token'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'username' => 'string',
        'auth_token' => 'string',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id');
    }
}
