<?php

namespace App\Service;

use SensitiveParameter;

// todo: вероятно, не Message, а что-то другое...
abstract class OtpMessage implements OtpMessageInterface
{
    private readonly string $code;

    public function __construct(
        #[SensitiveParameter]
        private readonly string $recipient_id,
        OtpGeneratorInterface $otpGenerator
    ) {
        $this->code = $otpGenerator();
    }

    final public function getRecipientId(): string
    {
        return $this->recipient_id;
    }

    final public function getCode(): string
    {
        return $this->code;
    }

    final public function __debugInfo(): array
    {
        return ['code' => $this->code];
    }
}
