<?php

declare(strict_types=1);

namespace App\Logger;

class Context
{
    public const INITIALIZATION = 1;
    public const BUSINESS = 2;
    public const DATAACCESS = 3;
    public const WEBCALL = 4;
    public const UI = 5;
    public const API = 6;
    public const QUEUELOGS = 7;

    public static array $typeEnum = [
        self::INITIALIZATION => 'Initialization',
        self::BUSINESS => 'Business',
        self::DATAACCESS => 'DataAccess',
        self::WEBCALL => 'WebCall',
        self::UI => 'UI',
        self::API => 'API',
        self::QUEUELOGS => 'QueueLogs',
    ];

    /**
     * Construct won't be called inside this class and is not callable from
     * the outside. This prevents instantiating this class.
     * This is by purpose, because we want a static class.
     */
    private function __construct()
    {
    }
}
