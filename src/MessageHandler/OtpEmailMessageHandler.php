<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\OtpEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OtpEmailMessageHandler extends OtpMessageHandler
{
    public function __invoke(OtpEmailMessage $message): void
    {
        $text = $this->getTextMessage($message);
        // send_email($email);
        file_put_contents('var/otp.txt', $message->getRecipientId() . ' : ' . $text . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
