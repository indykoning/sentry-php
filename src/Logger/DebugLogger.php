<?php

declare(strict_types=1);

namespace Sentry\Logger;

use Psr\Log\AbstractLogger;

abstract class DebugLogger extends AbstractLogger
{
    /**
     * @param mixed              $level
     * @param string|\Stringable $message
     * @param mixed[]            $context
     */
    public function log($level, $message, array $context = []): void
    {
        $contextJson = json_encode($context);
        if ($contextJson === false) {
            $contextJson = '[JSON encoding failed]';
        }
        
        $formattedMessageAndContext = implode(' ', array_filter([(string) $message, $contextJson]));

        $this->write(
            \sprintf("sentry/sentry: [%s] %s\n", $level, $formattedMessageAndContext)
        );
    }

    abstract public function write(string $message): void;
}
