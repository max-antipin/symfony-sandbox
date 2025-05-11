<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\OtpMessage;
use App\Service\OtpSmsMessage;
use App\Service\OtpGenerator;
use App\Service\OtpCharset;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[UsesClass(OtpGenerator::class)]
#[CoversClass(OtpMessage::class)]
#[CoversClass(OtpSmsMessage::class)]
class OtpMessageTest extends TestCase
{
    public function testDebugInfo(): void
    {
        $msg = new OtpSmsMessage('+79991234', new OtpGenerator(OtpCharset::NUMBER, 7));
        $info = $msg->__debugInfo();
        $this->assertArrayHasKey('code', $info);
        $this->assertCount(1, $info, 'No other fiels except \'code\'');
        $this->assertSame($msg->getCode(), $info['code']);
    }
}
