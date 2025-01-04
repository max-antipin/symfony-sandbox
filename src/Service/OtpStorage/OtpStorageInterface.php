<?php

declare(strict_types=1);

namespace App\Service\OtpStorage;

interface OtpStorageInterface
{
    public function get($uid);
    public function set($uid, $password): void;
    public function deleteExpired(): void;
}
