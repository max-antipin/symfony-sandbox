<?php

namespace App\Service;

// todo: вероятно, не Message, а что-то другое...
interface OtpMessageInterface
{
    public function getRecipientId(): string;
    public function getCode(): string;
}
