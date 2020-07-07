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
    private array $laps;

    /**
     * @var array{int, int}|null
     */
    private ?array $end;

    public function __construct()
    {
        $this->start = null;
        $this->laps = [];
        $this->end = null;
    }

    public function isStarted() : bool
    {
        return $this->start !== null;
    }

    public function isStopped() : bool
    {
        return $this->end !== null;
    }

    /**
     * Stopwatch::lap() used once will generate two laps, first between start and lap[0] and
     * second between lap[0] and end.
     */
    public function laps() : int
    {
        return \count($this->laps) > 0
            ? \count($this->laps) + 1
            : 0;
    }

    public function start() : void
    {
        $this->start = \hrtime(false);
    }

    public function lap() : void
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        $this->laps[] = \hrtime(false);
    }

    public function stop() : void
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if ($this->end !== null) {
            throw new Exception('Stopwatch already stopped');
        }

        $this->end = \hrtime(false);
    }

    public function elapsedTime(int $lap) : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if (\count($this->laps) === 0) {
            throw new Exception('Stopwatch does not have any laps.');
        }

        if ($lap === 1) {
            return $this->firstLapElapsedTime();
        }

        if ($lap - 1 === \count($this->laps)) {
            return $this->lastLapElapsedTime();
        }

        if (!isset($this->laps[$lap - 1])) {
            throw new Exception(\sprintf('Lap %d not exists', $lap));
        }

        return TimeUnit::precise($this->timeToFloat($this->laps[$lap - 1]))
            ->sub(TimeUnit::precise($this->timeToFloat($this->laps[$lap - 2])));
    }

    public function firstLapElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if (\count($this->laps) === 0) {
            throw new Exception('Stopwatch does not have any laps.');
        }

        return TimeUnit::precise($this->timeToFloat($this->laps[0]))
            ->sub(TimeUnit::precise($this->timeToFloat($this->start)));
    }

    public function lastLapElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if ($this->end === null) {
            throw new Exception('Stopwatch not stopped');
        }

        if (\count($this->laps) === 0) {
            throw new Exception('Stopwatch does not have any laps.');
        }

        return TimeUnit::precise($this->timeToFloat($this->end))
            ->sub(TimeUnit::precise($this->timeToFloat(\end($this->laps))));
    }

    public function totalElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if ($this->end === null) {
            throw new Exception('Stopwatch not stopped');
        }

        return TimeUnit::precise($this->timeToFloat($this->end))
            ->sub(TimeUnit::precise($this->timeToFloat($this->start)));
    }

    /**
     * @param array{int, int} $time
     */
    private function timeToFloat(array $time) : float
    {
        return (float) \sprintf(
            '%d.%s',
            $time[0],
            \substr(\str_pad((string) $time[1], 9, '0', STR_PAD_LEFT), 0, 6)
        );
    }
}
