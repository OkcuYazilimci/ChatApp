<?php

namespace ChatApp\Application\DTOs;

use Illuminate\Support\Str;

class CreateGroupDTO
{
    public string $id;
    public string $name;
    public string $user_id;
    public string $description;
    public int $member_number;

    public function __construct(string $name, string $user_id, string $description = '')
    {
        $this->id = (string) Str::uuid();
        $this->name = $name;
        $this->user_id = $user_id;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'description' => $this->description,
        ];
    }
}
