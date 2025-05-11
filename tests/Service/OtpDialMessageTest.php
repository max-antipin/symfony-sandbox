<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\OtpMessage;
use App\Service\OtpDialMessage;
use App\Service\OtpGenerator;
use App\Service\OtpCharset;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[UsesClass(OtpMessage::class)]
#[CoversClass(OtpDialMessage::class)]
class OtpDialMessageTest extends TestCase
{
    public function testSetEmptyCode(): void
    {
        $msg = new OtpDialMessage('+79991234');
        $this->expectException(\ValueError::class);
        $msg->setCode('');
    }

    public function testSetCodeTwice(): void
    {
        $msg = new OtpDialMessage('+79991234');
        $code = '98765';
        $msg->setCode($code);
        $this->assertSame($code, $msg->getCode());
        $this->expectException(\Error::class);
        $msg->setCode('01234');
    }

    public function testGetEmptyCode(): void
    {
        $msg = new OtpDialMessage('+79991234');
        $this->expectException(\Error::class);
        echo $msg->getCode();
    }

    public function testDebugInfo(): void
    {
        $msg = new OtpDialMessage('+79991234');
        $info = $msg->__debugInfo();
        $this->assertArrayHasKey('code', $info);
        $this->assertCount(1, $info, 'No other fiels except \'code\'');
        $this->assertNull($info['code']);
        $code = 'ABCD';
        $msg->setCode($code);
        $info = $msg->__debugInfo();
        $this->assertArrayHasKey('code', $info);
        $this->assertCount(1, $info, 'No other fiels except \'code\'');
        $this->assertSame($code, $info['code']);
    }
}
