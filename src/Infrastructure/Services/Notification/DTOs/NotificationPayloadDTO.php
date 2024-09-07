<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\DTOs;

class NotificationPayloadDTO
{
    public function __construct(
        public string $title,
        public string $message,
        public array $data = []
    ) { }

    public function makeMessage(): string
    {
        $message = $this->message;

        foreach ($this->data as $key => $value) {
            $message = str_replace(
                [
                    sprintf('{{%s}}', $key),
                    sprintf('{{ %s }}', $key),
                ],
                [
                    sprintf('{{%s}}', $key) => $value,
                    sprintf('{{ %s }}', $key) => $value,
                ],
                $this->message
            );
        }

        return $message;
    }
}