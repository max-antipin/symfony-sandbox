<?php

namespace App\Service;

interface OtpGeneratorInterface
{
    public function __invoke(): string;
}
