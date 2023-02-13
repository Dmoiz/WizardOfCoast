<?php 


namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class SimpleFormatter {
    public function __construct($logger) {
        foreach($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new LineFormatter('[%datetime%]: %message% %context%')    
            );
        }
    }
}