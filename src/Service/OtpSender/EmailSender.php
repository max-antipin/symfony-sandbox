<?php

namespace App\Service\OtpSender;

class EmailSender implements OtpSenderInterface
{
    public function validate(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function send(): void
    {
    }
}
