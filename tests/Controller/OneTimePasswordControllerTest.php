<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\OneTimePasswordController;
use App\Tests\AppWebTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\JsonResponse;

#[CoversClass(OneTimePasswordController::class)]
class OneTimePasswordControllerTest extends AppWebTestCase
{
    public function testSend(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            $this->generateUrl('register-send-otp'),
            ['uid' => 'max.v.antipin@gmail.com']
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
        /** @var JsonResponse $response */
        $response = $client->getResponse();
        var_dump($response->getContent());
    }

    // public function testSendEmptyEmail(): void
    // {
    //     $client = static::createClient();
    //     $client->request(
    //         'POST',
    //         $this->generateUrl('register-send-otp'),
    //     );
    //     $this->assertResponseStatusCodeSame(422);
    //     $this->assertResponseFormatSame('json');
    //     /** @var JsonResponse $response */
    //     $response = $client->getResponse();
    //     var_dump(json_decode($response->getContent()));
    // }

    // public function testVerify(): void
    // {
    //     $client = static::createClient();
    //     $client->request('POST', $this->generateUrl('register-verify-otp'));
    //     $this->assertResponseIsSuccessful();
    //     $this->assertResponseFormatSame('json');
    //     /** @var JsonResponse $response */
    //     $response = $client->getResponse();
    //     var_dump($response->getContent());
    // }
}
