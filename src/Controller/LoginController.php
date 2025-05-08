<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OtpGenerator;
use App\Service\OtpStorage\OtpStorageDoctrine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/login', name:'login-')]
class LoginController extends AbstractController
{
    #[Route('/send-otp', name:'send-otp', methods:'POST', format: 'json')]
    public function send(Request $request, ValidatorInterface $validator, OtpStorageDoctrine $otpStorage, OtpGenerator $otpGenerator): JsonResponse
    {
        //... user must NOT be logged in
        $email = $request->request->getString('uid');
        $emailConstraint = new Assert\Email();
        $errors = $validator->validate(
            $email,
            [new Assert\NotBlank(), $emailConstraint]
        );
        if ($errors->count()) {
            $errorMessage = $errors[0]->getMessage();
            return $this->json(['message' => $errorMessage], 422);
        }
        $otp = $otpStorage->get($email);
        $interval = 60;
        if ($otp) {
            $time_left = $interval - (time() - $otp['created_at']);
            if ($time_left > 0) {
                return $this->json(['message' => 'can not send code', 'time_left' => $time_left]);
            }
        }
        $password = $otpGenerator();
        $otpStorage->set($email, $password);
        // send_email($email);
        file_put_contents('var/otp.txt', $password . PHP_EOL, FILE_APPEND | LOCK_EX);
        return $this->json('success');
    }

    #[Route('/verify-otp', name:'verify-otp', methods:'POST', format: 'json')]
    public function verify(): JsonResponse
    {
        return $this->json(['verify code']);
    }
}
