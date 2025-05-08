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
    #[DataProvider('dataOtpAttrs')]
    public function testGenerator(OtpCharset $charset, int $length): void
    {
        $generator = new OtpGenerator($charset, $length);
        $otp = $generator();
        $this->assertSame($length, mb_strlen($otp));
        match ($charset) {
            OtpCharset::NUMBER => $this->assertIsNumeric($otp, 'Code must be a number'),
            OtpCharset::ALPHA_LC => $this->assertMatchesRegularExpression("/^[a-z]{{$length}}$/", $otp),
        };
    }

    public static function dataOtpAttrs(): \Generator
    {
        static $charsets = [OtpCharset::ALPHA_LC, OtpCharset::NUMBER];
        foreach ($charsets as $charset) {
            yield 'Minimal length' . $charset->name => [$charset, 4];
            yield 'Regular length' . $charset->name => [$charset, mt_rand(5, 9)];
        }
    }

    public function testLengthIsBelowMinimal(): void
    {
        $this->expectException(\ValueError::class);
        (new OtpGenerator(OtpCharset::ALPHA, mt_rand(1, 3)))();
    }
}
