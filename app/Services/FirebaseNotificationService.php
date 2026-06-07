<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;

class FirebaseNotificationService
{

    public function __construct(
        private Messaging $messaging
    ) {}

    public function send(
        string $token,
        string $title,
        string $body
    ) {

        $message =
        CloudMessage::withTarget(
            'token',
            $token
        )

        ->withData([
            'type' => 'watering',
            'timestamp' => now()->toDateTimeString(),
        ])

        ->withNotification(
            Notification::create(
                $title,
                $body
            )
        )

        ->withAndroidConfig(
            AndroidConfig::fromArray([
                'priority' => 'high',
            ])
        );

        $this->messaging->send(
            $message
        );
    }
}
