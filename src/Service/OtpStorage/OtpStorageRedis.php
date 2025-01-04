<?php

declare(strict_types=1);

namespace App\Service\OtpStorage;

use Redis;
use SensitiveParameter;

final readonly class OtpStorageRedis implements OtpStorageInterface
{
    public function __construct(
        string $host,
        int $port,
        #[SensitiveParameter()]
        string $username,
        #[SensitiveParameter()]
        string $password,
        private int $ttl_minutes,
    ) {
        $this->redis = new Redis([
            'host' => $host,
            'port' => $port,
            'auth' => [$username, $password],
        ]);
    }

    public function get($uid)
    {
        return $this->redis->hGetAll($this->mkKey($uid));
    }

    public function set($uid, $password): void
    {
        $key = $this->mkKey($uid);
        $this->redis->hMSet($key, ['uid' => $uid, 'password' => $password, 'created_at' => time()]);
        // + 90 second to compensate delays.
        $this->redis->expire($key, $this->ttl_minutes * 60 + 90);
    }

    public function deleteExpired(): void
    {
        // This method is empty because we use Redis EXPIRE.
    }

    private function mkKey($uid): string
    {
        return 'otp:' . $uid;
    }

    private Redis $redis;
}
