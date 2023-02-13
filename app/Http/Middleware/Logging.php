<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Illuminate\Support\Str;

class Logging
{
    private $logger;

    public function __construct() {
        $this->logger = $this->getLogger();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->logger->info('Incoming request:');
        $this->logger->info($request);
        return $next($request);
    }

    /* public function terminate(Request $request, Response $response)
    {
        $this->logger->info('Outgoing response:');
        $this->logger->info($response);
    } */

    private function getLogger()
    {
        $dateString = now()->format('d_m_Y');

        $filePath = 'logs_' . $dateString . '.log';

        $dateFormat = "m/d/Y H:i:s";
        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler(storage_path('logs/' . $filePath), Logger::DEBUG);
        $stream->setFormatter($formatter);
        
        $processId = Str::random(5);
        $logger = new Logger($processId);
        $logger->pushHandler($stream);
        
        return $logger;
    }
}
