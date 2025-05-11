<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\OtpMessage;
use App\Service\OtpSmsMessage;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OtpMessage::class)]
#[CoversClass(OtpSmsMessage::class)]
class OtpMessageTest extends TestCase
{
    public function testSetCodeTwice(): void
    {
        $msg = new OtpSmsMessage('+79991234');
        $code = '98765';
        $msg->setCode($code);
        $this->assertSame($code, $msg->getCode());
        $this->expectException(\Error::class);
        $msg->setCode('01234');
    }

    public function testGetEmptyCode(): void
    {
        $msg = new OtpSmsMessage('+79991234');
        $this->expectException(\Error::class);
        echo $msg->getCode();
    }
}
