<?php

declare(strict_types=1);

namespace Aeon\Calendar;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\TimeUnit\HRTime;

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

        return HRTime::convert($this->laps[$lap - 1][0], $this->laps[$lap - 1][1])
            ->sub(HRTime::convert($this->laps[$lap - 2][0], $this->laps[$lap - 2][1]));
    }

    public function firstLapElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if (\count($this->laps) === 0) {
            throw new Exception('Stopwatch does not have any laps.');
        }

        return HRTime::convert($this->laps[0][0], $this->laps[0][1])
            ->sub(HRTime::convert($this->start[0], $this->start[1]));
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

        return HRTime::convert($this->end[0], $this->end[1])
            ->sub(HRTime::convert(\end($this->laps)[0], \end($this->laps)[1]));
    }

    public function totalElapsedTime() : TimeUnit
    {
        if ($this->start === null) {
            throw new Exception('Stopwatch not started');
        }

        if ($this->end === null) {
            throw new Exception('Stopwatch not stopped');
        }

        return HRTime::convert($this->end[0], $this->end[1])
            ->sub(HRTime::convert($this->start[0], $this->start[1]));
    }
}
