<?php

namespace Rnr\Tests\LoggerMock;

use Illuminate\Contracts\Logging\Log;
use Orchestra\Testbench\TestCase as ParentTestCase;
use Rnr\LoggerMock\LoggerMock;

/**
 * @author Sergei Melnikov<me@rnr.name>
 */
class TestCase extends ParentTestCase
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->instance(Log::class, new LoggerMock($app));
    }
}
