<?php

namespace App\Service;

readonly class OtpGenerator
{
    public const MIN_LENGTH = 4;

    public function __construct(private OtpCharset $otp_charset, private int $otp_length)
    {
        if ($otp_length < self::MIN_LENGTH) {
            throw new \ValueError('Length must be greater than or equal to ' . self::MIN_LENGTH);
        }
        $this->chars = array_merge(range('a', 'z'), range('A', 'Z'));
    }

    public function __invoke(): string
    {
        return match ($this->otp_charset) {
            OtpCharset::NUMBER => sprintf("%0{$this->otp_length}d", random_int(0, 10 ** $this->otp_length)),
            OtpCharset::ALPHA => $this->generateAlpha(),
            OtpCharset::ALPHA_LC => strtolower($this->generateAlpha()),
            OtpCharset::ALPHA_UC => strtoupper($this->generateAlpha())
        };
    }

    private function generateAlpha(): string
    {
        $str = '';
        $c = count($this->chars);
        foreach (str_split(random_bytes($this->otp_length)) as $char) {
            $str .= $this->chars[ord($char) % $c];
        }
        return $str;
    }

    private array $chars;
}
