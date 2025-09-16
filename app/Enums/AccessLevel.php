<?php

namespace App\Enums;

enum AccessLevel: int
{
    case SUPER_ADMIN = 0;
    case ADMIN = 1;
    case MODERATOR = 10;
    case USER = 100;
    case BANNED = 1000;

    public function label(): string
    {
        return match($this) {
            AccessLevel::SUPER_ADMIN => 'Super Admin',
            AccessLevel::ADMIN => 'Admin',
            AccessLevel::MODERATOR => 'Moderator',
            AccessLevel::USER => 'Member',
            AccessLevel::BANNED => 'Banned',
        };
    }

    public function canAccess(AccessLevel $requiredLevel): bool
    {
        return $this->value <= $requiredLevel->value;
    }
}