<?php

declare(strict_types=1);

namespace App\Message;

final readonly class SmsMessage
{
    public function __construct(
        private string $phoneNumber,
        private string $message
    ) {}

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
