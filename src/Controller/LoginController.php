<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OtpEmptyGenerator;
use App\Service\OtpStorage\OtpStorageDoctrine;
use App\Service\OtpDialMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/login', name:'login-')]
class LoginController extends AbstractController
{
    #[Route('/send-otp', name:'send-otp', methods:'POST', format: 'json')]
    public function send(Request $request, ValidatorInterface $validator, OtpStorageDoctrine $otpStorage, OtpEmptyGenerator $otpGenerator, MessageBusInterface $messageBus): JsonResponse
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
        $message = new OtpDialMessage($email, ($otpGenerator)());// todo: use phone number!!!
        // send message without code to transport
        $messageBus->dispatch($message);
        $otpStorage->set($message->getRecipientId(), $message->getCode());
        return $this->json('success');
    }

    #[Route('/verify-otp', name:'verify-otp', methods:'POST', format: 'json')]
    public function verify(): JsonResponse
    {
        return $this->json(['verify code']);
    }
}
