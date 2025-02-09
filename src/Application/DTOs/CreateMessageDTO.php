<?php

namespace ChatApp\Application\DTOs;

use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateMessageDTO
{
    public string $id;
    public string $user_id;
    public string $group_id;
    public string $content;

    public function __construct(string $user_id, string $group_id, string $content)
    {
        $this->id = (string) Str::uuid();
        $this->user_id = $user_id;
        $this->group_id = $group_id;
        $this->content = $content;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'content' => $this->content,
            'created_at' => Carbon::now(),
        ];
    }
}
