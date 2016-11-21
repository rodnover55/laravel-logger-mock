<?php

namespace Rnr\LoggerMock;

use Illuminate\Contracts\Logging\Log;

/**
 * @author Sergei Melnikov<me@rnr.name>
 */
trait LoggerAssertionTrait
{
    /**
     * @param bool $condition
     * @param string $message
     *
     * @return mixed
     */
    abstract public function assertFalse($condition, $message = '');

    /**
     * @param string $level
     * @param string $message
     * @param array|null $context
     */
    public function assertLog($level, $message, $context = null)
    {
        /** @var LoggerMock $log */
        $log = $this->app->make(Log::class);

        $this->assertTrue($log->contains($level, $message, $context), 'Log record not found.');
    }
}
