<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\OtpGenerator;
use App\Service\OtpMessage;

abstract class OtpMessageHandler
{
    public function __construct(protected readonly OtpGenerator $otpGenerator)
    {
    }

    protected function getTextMessage(OtpMessage $message): string
    {
        $message->setCode(($this->otpGenerator)());
        // Fetch email or sms template
        // Create email or sms body
        return "Your one-time password: {$message->getCode()}";
    }
}
