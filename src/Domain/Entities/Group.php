<?php

namespace ChatApp\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    public $incrementing = false;
    public mixed $description;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'user_id', 'description', 'member_number'];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'description' => 'string',
        'member_number' => 'integer',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }
}
