<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OtpGenerator;
use App\Service\OtpStorage\OtpStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/confirm', name:'confirm-')]
class ConfirmationController extends AbstractController
{
    #[Route('/send-otp', name:'send-otp', methods:'POST', format: 'json')]
    public function send(Request $request, ValidatorInterface $validator, OtpStorageInterface $otpStorage, OtpGenerator $otpGenerator): JsonResponse
    {
        //... user must be logged in
        return $this->json('success');
    }

    #[Route('/verify-otp', name:'verify-otp', methods:'POST', format: 'json')]
    public function verify(): JsonResponse
    {
        return $this->json(['verify code']);
    }
}
