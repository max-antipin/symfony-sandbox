<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\OtpDialMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OtpDialMessageHandler
{
    public function __invoke(OtpDialMessage $message): void
    {
        // Get last digits from service provider API
        // здесь же при получении цифр происходит звонок юзеру, поэтому ничего не делаем дополнительно.
        $message->setCode('000000');
    }
}
