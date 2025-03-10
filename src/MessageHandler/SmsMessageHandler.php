<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SmsMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SmsMessageHandler
{
    public function __invoke(SmsMessage $message): void
    {
        var_dump($message->getMessage());
    }
}
