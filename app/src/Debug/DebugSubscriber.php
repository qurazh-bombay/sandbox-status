<?php
declare(strict_types=1);

namespace App\Debug;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DebugSubscriber implements EventSubscriberInterface
{
    #[ArrayShape([KernelEvents::EXCEPTION => "array"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['debug', 128]
        ];
    }

    // throw new \App\Debug\DebugException($shop);
    public function debug(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if (!$e instanceof DebugException) {
            throw $e;
        }

        $response = new Response('<pre>' . json_encode($e->payload));

        if ($e->withDebugType) {
            $response = new Response('<pre>' . get_debug_type($e->payload));
        } else {
            $response = new Response('<pre>' . print_r($e->payload, true));
        }


        $event->setResponse($response);
    }
}