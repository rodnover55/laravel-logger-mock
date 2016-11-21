<?php

namespace Rnr\Tests\LoggerMock;

use Illuminate\Contracts\Logging\Log;
use Rnr\LoggerMock\LoggerAssertionTrait;
use PHPUnit_Framework_ExpectationFailedException;
use Generator;

/**
 * @author Sergei Melnikov<me@rnr.name>
 */
class LoggerTest extends TestCase
{
    use LoggerAssertionTrait;

    /** @var Log */
    private $log;

    /**
     * @dataProvider messagesProvider
     *
     * @param string $level
     * @param string $message
     */
    public function testLevel($level, $message)
    {
        $this->log->{$level}($message);

        $this->assertLog($level, $message);
    }

    /**
     * @dataProvider messagesProviderWithContext
     *
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function testLevelWithContext($level, $message, $context)
    {
        $this->log->{$level}($message, $context);

        $this->assertLog($level, $message, $context);
    }

    public function testAssertionFalse()
    {
        try {
            $this->assertLog('debug', 'test');
            $this->fail('Assert was not thrown');
        } catch (PHPUnit_Framework_ExpectationFailedException $e) {
        }
    }

    public function testAssertionFalseWithContext()
    {
        try {
            $this->log->debug('test');
            $this->assertLog('debug', 'test', ['test']);
            $this->fail('Assert was not thrown');
        } catch (PHPUnit_Framework_ExpectationFailedException $e) {
        }
    }

    /**
     * @return array
     */
    public function messagesProvider()
    {
        return [
            'alert' => [
                'alert', 'Alert Message'
            ],
            'critical' => [
                'critical', 'Critical Message'
            ],
            'error' => [
                'error', 'Error Message'
            ],
            'warning' => [
                'warning', 'Warning Message'
            ],
            'notice' => [
                'notice', 'Notice Message'
            ],
            'info' => [
                'info', 'Info Message'
            ],
            'debug' => [
                'debug', 'Debug message'
            ]
        ];
    }

    /**
     * @return Generator
     */
    public function messagesProviderWithContext()
    {
        foreach ($this->messagesProvider() as $key => $data) {
            yield array_merge($data, [[$key]]);
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->log = $this->app->make(Log::class);
    }
}
