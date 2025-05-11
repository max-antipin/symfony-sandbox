<?php

namespace App\Service;

use SensitiveParameter;

// todo: вероятно, не Message, а что-то другое...
abstract class OtpMessage implements OtpMessageInterface
{
    private string $code;

    public function __construct(
        #[SensitiveParameter]
        private readonly string $recipient_id
    ) {
    }

    final public function getRecipientId(): string
    {
        return $this->recipient_id;
    }

    final public function getCode(): string
    {
        return $this->code;
    }

    final public function setCode(string $code): self
    {
        if (isset($this->code)) {
            throw new \Error(sprintf('Cannot modify readonly property %s::$code', get_debug_type($this)));
        }
        $this->code = $code;
        return $this;
    }

    final public function __debugInfo(): array
    {
        return ['code' => $this->code ?? null];
    }
}
