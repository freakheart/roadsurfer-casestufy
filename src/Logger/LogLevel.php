<?php

declare(strict_types=1);

namespace App\Logger;

class LogLevel
{
    public const ERROR = 1 << 0;
    public const WARNING = 1 << 1;
    public const DOC = 1 << 2;
    public const DEBUG = 1 << 3;
    public const VERBOSE = 1 << 4;

    public static array $typeEnum = [
        self::ERROR => 'Error',
        self::WARNING => 'Warning',
        self::DOC => 'Doc',
        self::DEBUG => 'Debug',
        self::VERBOSE => 'Verbose',
    ];

    /**
     * Construct won't be called inside this class and is uncallable from
     * the outside. This prevents instantiating this class.
     * This is by purpose, because we want a static class.
     */
    private function __construct()
    {
    }
}
