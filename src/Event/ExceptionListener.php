<?php

declare(strict_types=1);

namespace App\Event;

use App\Logger\LogItem;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use function time;

class ExceptionListener
{
    private LogItem $logger;

    public function __construct(LogItem $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $token = Uuid::uuid4()->toString();
        $this->setLog($event, $token);

        $exception = $event->getThrowable();
        $message = sprintf(
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent($message);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }

    private function setLog(ExceptionEvent $event, string $token): void
    {
        $exception = $event->getThrowable();

        $this->logger->setTimeStamp(time());
        $this->logger->setSessionId($event->getRequest()->getSession()->getId());
        $this->logger->setMessage($exception->getMessage());
//        $this->logger->setCallingFunction($event->getRequest()->attributes->get('_controller'));
        $this->logger->setContext(1);
        $this->logger->setDomain($event->getRequest()->getUri());
        $this->logger->setLogLevel(1);
        $this->logger->setToken($token);

        $this->logger->writeToLog();
    }
}
