<?php

declare(strict_types=1);

namespace App\Service\OtpStorage;

use Doctrine\DBAL\Connection;

final readonly class OtpStorageDoctrine implements OtpStorageInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function get($uid)
    {
        // $message = $this->connection->createQueryBuilder()->select()->from('otp')->fetchAssociative();
    }

    public function set($uid, $password): void
    {
        // Doctrine\DBAL\Exception\UniqueConstraintViolationException
        // $this->connection->createQueryBuilder()->insert('otp')->values(['uid' => ':uid', 'password' => ':password', 'created_at' => 'NOW()'])->setParameters(['uid' => $email, 'password' => $password, ])->executeStatement();
    }

    public function deleteExpired(): void
    {
    }
}
