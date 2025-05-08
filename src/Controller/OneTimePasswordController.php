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

#[Route('/register', name:'register-')]
class OneTimePasswordController extends AbstractController
{
    #[Route('/send-otp', name:'send-otp', methods:'POST', format: 'json')]
    public function send(Request $request, ValidatorInterface $validator, OtpStorageInterface $otpStorage, OtpGenerator $otpGenerator): JsonResponse
    {
        // Generator generates code
        // OTP code/password, TTL, created at
        // Channel to send (delivery channel): email, phone (sms or call), telegram bot, push
        // Storage: Redis, MySQL, Postgres, Mongo
        // User ID
        // от канала зависит алгоритм валидации
        // Invalid uid
        // no such uid
        // password (code) expired
        // invalid password (code)
        // user banned
        // timeout
        // too many tries
        // Storage is down
        $email = $request->request->getString('uid');
        $emailConstraint = new Assert\Email();
        // Сейчас мы должны не просто проверять правильность переданного телефона или мыла, но
        // мы должны определить, что именно было передано, и далее выбрать обработчик.
        // Т.е.: передали телефон - шлём через смс\звонок; передали email - отправляем письмо.
        // Получается, что соответствующие сервисы должны быть ленивыми.
        // all constraint "options" can be set this way
        // $emailConstraint->message = 'Invalid email address';
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
        $otpStorage->set($email, $password);// В случае дозвона пароль приходит от сервиса, и сохранение в storage происходит ПОСЛЕ отправки, а не до.
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
