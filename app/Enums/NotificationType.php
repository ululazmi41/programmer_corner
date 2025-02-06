<?php

namespace App\Enums;

enum NotificationType: string
{
    case LIKE = 'like';
    case FOLLOW = 'follow';
    case COMMENT = 'comment';
    case REPLY = 'reply';
    case PROMOTE = 'promote';
    case DEMOTE = 'demote';
}
