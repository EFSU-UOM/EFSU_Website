<?php

namespace App;

enum ForumCategory: string
{
    case GENERAL = 'general';
    case ACADEMIC = 'academic';
    case TECHNICAL = 'technical';
    case SOCIAL = 'social';

    public function label(): string
    {
        return match ($this) {
            self::GENERAL => 'General',
            self::ACADEMIC => 'Academic',
            self::TECHNICAL => 'Technical',
            self::SOCIAL => 'Social',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::GENERAL => 'General discussions and community topics',
            self::ACADEMIC => 'Course help, study tips, and academic discussions',
            self::TECHNICAL => 'Programming, projects, and technical help',
            self::SOCIAL => 'Events, meetups, and social discussions',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::GENERAL => 'o-chat-bubble-left-ellipsis',
            self::ACADEMIC => 'o-book-open',
            self::TECHNICAL => 'o-cpu-chip',
            self::SOCIAL => 'o-users',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::GENERAL => 'primary',
            self::ACADEMIC => 'success',
            self::TECHNICAL => 'secondary',
            self::SOCIAL => 'warning',
        };
    }
}
