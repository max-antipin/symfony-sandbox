<?php

namespace App\Service;

final readonly class OtpEmptyGenerator implements OtpGeneratorInterface
{
    public function __invoke(): string
    {
        return '';
    }
}
