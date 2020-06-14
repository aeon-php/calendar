<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Stopwatch;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class StopwatchTest extends TestCase
{
    public function test_stopping_not_stared_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->stop();
    }

    public function test_getting_last_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not stopped');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->lastElapsedTime();
    }

    public function test_getting_last_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->lastElapsedTime();
    }

    public function test_getting_first_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not stopped');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->firstElapsedTime();
    }

    public function test_getting_first_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->firstElapsedTime();
    }

    public function test_getting_total_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not stopped');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->totalElapsedTime();
    }

    public function test_getting_total_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->totalElapsedTime();
    }

    public function test_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not stopped');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->elapsedTime(1);
    }

    public function test_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->elapsedTime(1);
    }

    public function test_elapsed_time_from_not_existing_measure() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Measurement 10 not exists');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();
        $stopwatch->elapsedTime(10);
    }

    public function test_getting_elapsed_time_from_one_stop() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->lastElapsedTime()->inSecondsPreciseString(),
            $stopwatch->firstElapsedTime()->inSecondsPreciseString()
        );
    }

    public function test_getting_elapsed_time_from_two_stops() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();
        \usleep(TimeUnit::milliseconds(100)->microsecond());
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->lastElapsedTime()->inSecondsPreciseString(),
            $stopwatch->elapsedTime(2)->inSecondsPreciseString()
        );
        $this->assertSame(
            $stopwatch->firstElapsedTime()->inSecondsPreciseString(),
            $stopwatch->elapsedTime(1)->inSecondsPreciseString()
        );
    }

    public function test_getting_total_elapsed_time_from_two_stops() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();
        \usleep(TimeUnit::milliseconds(100)->microsecond());
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->totalElapsedTime()->inSecondsPreciseString(),
            $stopwatch->firstElapsedTime()->add($stopwatch->lastElapsedTime())->inSecondsPreciseString()
        );
    }

    public function test_getting_total_elapsed_time_from_one_stop() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->totalElapsedTime()->inSecondsPreciseString(),
            $stopwatch->firstElapsedTime()->inSecondsPreciseString()
        );
    }
}
