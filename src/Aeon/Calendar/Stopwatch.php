<?php

declare(strict_types=1);

namespace Aeon\Calendar;

use Aeon\Calendar\Exception\Exception;

/**
 * @psalm-pure
 */
final class Stopwatch
{
    /**
     * @var array{int, int}|null
     */
    private ?array $start;

    /**
     * @var array<array{int, int}>
     */
    private array $ends;

    public function __construct()
    {
        $this->start = null;
        $this->ends = [];
    }

    public function start() : void
    {
        $this->start = \hrtime(false);
    }

    public function stop() : void
    {
        if ($this->start === null) {
            throw new Exception("Stopwatch not started");
        }

        $this->ends[] = \hrtime(false);
    }

    public function elapsedTime(int $measurement) : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception("Stopwatch not started");
        }

        if (\count($this->ends) === 0) {
            throw new Exception("Stopwatch not stopped");
        }

        if (!isset($this->ends[$measurement - 1])) {
            throw new Exception(\sprintf("Measurement %d not exists", $measurement));
        }

        if ($measurement === 1) {
            return $this->firstElapsedTime();
        }

        return TimeUnit::precise($this->timeToFloat($this->ends[$measurement - 1]))
            ->sub(TimeUnit::precise($this->timeToFloat($this->ends[$measurement - 2])));
    }

    public function firstElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception("Stopwatch not started");
        }

        if (\count($this->ends) === 0) {
            throw new Exception("Stopwatch not stopped");
        }

        if (\count($this->ends) === 1) {
            return $this->totalElapsedTime();
        }

        return TimeUnit::precise($this->timeToFloat($this->ends[0]))
            ->sub(TimeUnit::precise($this->timeToFloat($this->start)));
    }

    public function lastElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception("Stopwatch not started");
        }

        if (\count($this->ends) === 0) {
            throw new Exception("Stopwatch not stopped");
        }

        if (\count($this->ends) === 1) {
            return $this->totalElapsedTime();
        }

        return TimeUnit::precise($this->timeToFloat(\end($this->ends)))
            ->sub(TimeUnit::precise($this->timeToFloat($this->ends[\count($this->ends) - 2])));
    }

    public function totalElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception("Stopwatch not started");
        }

        if (\count($this->ends) === 0) {
            throw new Exception("Stopwatch not stopped");
        }

        return TimeUnit::precise($this->timeToFloat(\end($this->ends)))
            ->sub(TimeUnit::precise($this->timeToFloat($this->start)));
    }

    /**
     * @param array{int, int} $time
     */
    private function timeToFloat(array $time) : float
    {
        return (float)\sprintf(
            "%d.%s",
            $time[0],
            \str_pad((string) $time[1], 9, "0", STR_PAD_LEFT)
        );
    }
}
