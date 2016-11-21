<?php

namespace Rnr\LoggerMock;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Logging\Log;
use Exception;
use Illuminate\Support\Collection;

/**
 * @author Sergei Melnikov<me@rnr.name>
 */
class LoggerMock implements Log
{
    /**
     * @var Collection
     */
    public $messages;

    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->messages = new Collection();
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = [])
    {
        $this->addRecord('alert', $message, $context);
        $this->getLog()->alert($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function critical($message, array $context = [])
    {
        $this->addRecord('critical', $message, $context);
        $this->getLog()->critical($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function error($message, array $context = [])
    {
        $this->addRecord('error', $message, $context);
        $this->getLog()->error($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function warning($message, array $context = [])
    {
        $this->addRecord('warning', $message, $context);
        $this->getLog()->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function notice($message, array $context = [])
    {
        $this->addRecord('notice', $message, $context);
        $this->getLog()->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = [])
    {
        $this->addRecord('info', $message, $context);
        $this->getLog()->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function debug($message, array $context = [])
    {
        $this->addRecord('debug', $message, $context);
        $this->getLog()->debug($message, $context);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     */
    public function log($level, $message, array $context = [])
    {
        $this->addRecord($level, $message, $context);
        $this->getLog()->log($level, $message, $context);
    }

    /**
     * @param string $path
     * @param string $level
     *
     * @throws Exception
     */
    public function useFiles($path, $level = 'debug')
    {
        $this->getLog()->useFiles($path, $level);
    }

    /**
     * @param string $path
     * @param int $days
     * @param string $level
     *
     * @throws Exception
     */
    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
        $this->getLog()->useDailyFiles($path, $days, $level);
    }

    /**
     * @return Log
     */
    protected function getLog()
    {
        return $this->container->make('log');
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     */
    protected function addRecord($level, $message, array $context = [])
    {
        $this->messages->push([
            'level' => $level,
            'message' => $message,
            'context' => $context
        ]);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array|null $context
     *
     * @return bool
     */
    public function contains($level, $message, $context = null)
    {
        return !is_null($this->messages->first(function ($item) use ($level, $message, $context) {
            return
                ($item['level'] == $level) &&
                ($item['message'] == $message) &&
                (is_null($context) || $item['context'] == $context);
        }));
    }
}
