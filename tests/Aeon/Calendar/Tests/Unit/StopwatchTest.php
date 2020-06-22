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

    public function test_stopping_already_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch already stopped');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();
        $stopwatch->stop();
    }

    public function test_taking_lap_time_of_non_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->lap();
    }

    public function test_getting_last_lap_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch does not have any laps');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->stop();
        $stopwatch->lastLapElapsedTime();
    }

    public function test_getting_last_lap_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->lastLapElapsedTime();
    }

    public function test_getting_first_lap_elapsed_time_from_not_stopped_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch does not have any laps');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->firstLapElapsedTime();
    }

    public function test_getting_first_lap_elapsed_time_from_not_started_stopwatch() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Stopwatch not started');

        $stopwatch = new Stopwatch();
        $stopwatch->firstLapElapsedTime();
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
        $this->expectExceptionMessage('Stopwatch does not have any laps');

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
        $this->expectExceptionMessage('Lap 10 not exists');

        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->lap();
        $stopwatch->stop();
        $stopwatch->elapsedTime(10);
    }

    public function test_getting_elapsed_time_from_two_laps() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->lap(); // lap #1
        $stopwatch->stop(); // lap #2

        $this->assertSame(
            $stopwatch->lastLapElapsedTime()->inSecondsPreciseString(),
            $stopwatch->elapsedTime(2)->inSecondsPreciseString()
        );
        $this->assertSame(
            $stopwatch->firstLapElapsedTime()->inSecondsPreciseString(),
            $stopwatch->elapsedTime(1)->inSecondsPreciseString()
        );
    }

    public function test_getting_total_elapsed_time_from_three_laps() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        \usleep(TimeUnit::milliseconds(100)->microsecond()); // lap #1 aka first
        $stopwatch->lap();
        \usleep(TimeUnit::milliseconds(100)->microsecond()); // lap #2
        $stopwatch->lap();
        \usleep(TimeUnit::milliseconds(100)->microsecond()); // lap #3 aka last
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->totalElapsedTime()->inSecondsPreciseString(),
            $stopwatch->firstLapElapsedTime()
                ->add($stopwatch->elapsedTime(2))
                ->add($stopwatch->lastLapElapsedTime())
                ->inSecondsPreciseString()
        );
    }

    public function test_getting_total_elapsed_time_from_one_lap_stop() : void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();
        $stopwatch->lap();
        \usleep(TimeUnit::milliseconds(100)->microsecond());
        $stopwatch->stop();

        $this->assertSame(
            $stopwatch->totalElapsedTime()->inSecondsPreciseString(),
            $stopwatch->firstLapElapsedTime()->add($stopwatch->lastLapElapsedTime())->inSecondsPreciseString()
        );
    }
}
