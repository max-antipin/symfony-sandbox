<?php

namespace App\Service;

use SensitiveParameter;

// todo: вероятно, не Message, а что-то другое...
final class OtpDialMessage implements OtpMessageInterface
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
        if (empty($this->code)) {
            throw new \Error($this->getErrMsg('Typed property %s::$code must not be accessed before initialization'));
        }
        return $this->code;
    }

    final public function setCode(string $code): self
    {
        if (empty($code)) {
            throw new \ValueError('Code can not be empty');
        }
        if (!empty($this->code)) {
            throw new \Error($this->getErrMsg('Cannot modify readonly property %s::$code'));
        }
        $this->code = $code;
        return $this;
    }

    final public function __debugInfo(): array
    {
        return ['code' => $this->code ?? null];
    }

    final protected function getErrMsg(string $tpl): string
    {
        return sprintf($tpl, get_debug_type($this));
    }
}
