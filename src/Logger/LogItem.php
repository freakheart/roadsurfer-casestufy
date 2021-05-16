<?php

declare(strict_types=1);

namespace App\Logger;

use function debug_backtrace;
use Exception;
use function get_object_vars;
use function implode;
use function json_encode;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use function str_replace;
use Symfony\Component\HttpFoundation\Request;
use function time;

class LogItem implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private string $message;

    private ?string $callingFunction;

    private ?array $input;

    private ?array $output;

    private string $context;

    private string $domain;

    private int $level;

    private string $logLevel;

    private ?string $token;

    private string $sessionId;

    private ?int $timestamp;

    public function setTimeStamp(?int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setCallingFunction(?string $callingFunction): void
    {
        $this->callingFunction = $callingFunction;
    }

    public function setContext(int $context): void
    {
        $this->context = Context::$typeEnum[$context];
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function setLogLevel(int $level): void
    {
        $this->level = $level;
        $this->logLevel = LogLevel::$typeEnum[$level];
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function setInput(?array $input): void
    {
        $this->input = $input;
    }

    public function setOutput(?array $output): void
    {
        $this->output = $output;
    }

    public function writeLog(Request $request, int $context, int $level, ?array $input = null, ?array $output = null): void
    {
        $this->setTimeStamp(time());
        $this->setSessionId($request->getSession()->getId());
        $this->setMessage($request->attributes->get('_route'));
        $this->setCallingFunction($request->attributes->get('_controller'));
        $this->setContext($context);
        $this->setDomain($request->getUri());
        $this->setLogLevel($level);
        $this->setInput($input);
        $this->setOutput($output);

        $this->writeToLog();
    }

    public function log(string $message, int $context, int $level, ?array $input = null, ?array $output = null): void
    {
        $this->setTimeStamp(time());
        $this->setMessage($message);
        $this->setCallingFunction(implode(',', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0]));
        $this->setContext($context);
        $this->setLogLevel($level);
        $this->setInput($input);
        $this->setOutput($output);

        $this->writeToLog();
    }

    public function writeToLog(): void
    {
        $jsonContent = $this->jsonEncode(get_object_vars($this));

        if (null == $jsonContent) {
            $this->logger->error('jsonEncode failed...');

            return;
        }

        switch ($this->level) {
            case LogLevel::ERROR:
                $this->logger->error($jsonContent);
                break;
            case LogLevel::WARNING:
                $this->logger->warning($jsonContent);
                break;
            case LogLevel::DEBUG:
                $this->logger->debug($jsonContent);
                break;
            default:
                $this->logger->info($jsonContent);
        }
    }

    private function jsonEncode(?array $data): string
    {
        try {
            if ($data = json_encode($data)) {
                return str_replace('\\u0000', '', $data);
            }
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }

        return '';
    }
}
