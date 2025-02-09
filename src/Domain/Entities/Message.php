<?php

namespace ChatApp\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'messages';
    protected $fillable = ['id', 'user_id', 'group_id', 'content', 'created_at'];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'group_id' => 'string',
        'content' => 'string',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
