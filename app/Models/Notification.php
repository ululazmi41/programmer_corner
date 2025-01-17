<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'notifier_id',
        'notifiable_id',
        'notifiable_type',
        'type',
    ];

    static public function sendNotification(
        int $userId,
        int $notifierId,
        NotificationType $type,
        String $notifiableType,
        int $notifiableId
    ) {
        $user = User::find($userId);

        $notification = $user->notifications()
        ->where('type', $type)
        ->where('notifier_id', $notifierId)
        ->where('notifiable_id', $notifiableId)
        ->where('notifiable_type', $notifiableType);

        if (!$notification->exists()) {
            $user->notifications()->create([
                'type' => $type,
                'notifier_id' => $notifierId,
                'notifiable_id' => $notifiableId,
                'notifiable_type' => $notifiableType,
            ]);
        }
    }

    static public function removeNotification(
        int $userId,
        int $notifierId,
        NotificationType $type,
        String $notifiableType,
        int $notifiableId
    ) {
        $user = User::find($userId);

        $notification = $user->notifications()
        ->where('type', $type)
        ->where('notifier_id', $notifierId)
        ->where('notifiable_id', $notifiableId)
        ->where('notifiable_type', $notifiableType);

        if ($notification->exists()) {
            $notification->delete();
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notifier_id');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead()
    {
        $this->update(['read', true]);
    }
}
