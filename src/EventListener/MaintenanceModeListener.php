<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\Logger;

#[When(env: 'dev')]
#[When(env: 'test')]
#[AsEventListener(event: 'kernel.request', priority: 255)]
class MaintenanceModeListener
{
    // public function __construct(private readonly Logger $logger) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        // if ($this->maintenanceMode) {
        //     $event->setResponse(new RedirectResponse('/maintenance'));
        // }
        // $event->setResponse(new JsonResponse(['test']));
        // $this->logger->debug('testing test');
    }
}
