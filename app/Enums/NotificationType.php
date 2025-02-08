<?php

namespace App\Enums;

enum NotificationType: string
{
    case LIKE = 'like';
    case COMMENT = 'comment';
    case REPLY = 'reply';
    case FOLLOW = 'follow';
    case PROMOTE = 'promote';
    case DEMOTE = 'demote';
}
