<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\OtpCharset;
use App\Service\OtpGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OtpGenerator::class)]
class OtpGeneratorTest extends TestCase
{
    #[DataProvider('dataCodeLength')]
    public function testGenerator(int $length): void
    {
        $generator = new OtpGenerator(OtpCharset::ALPHA, $length);
        $otp = $generator();
        $this->assertSame($length, mb_strlen($otp));
    }

    public static function dataCodeLength(): array
    {
        return [
            'Minimal length' => [4],
            'Regular length' => [mt_rand(5, 9)],
        ];
    }

    public function testLengthBelowMinimal(): void
    {
        $this->expectException(\ValueError::class);
        (new OtpGenerator(OtpCharset::ALPHA, 2))();
    }
}
