<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class Interval
{
    public const CLOSED = 0;

    public const LEFT_OPEN = 1;

    public const RIGHT_OPEN = 2;

    public const OPEN = 4;

    private int $type;

    private function __construct(int $type)
    {
        $this->type = $type;
    }

    /**
     * A <= x <= B.
     *
     * @psalm-pure
     */
    public static function closed() : self
    {
        return new self(self::CLOSED);
    }

    /**
     * A <= x < B.
     *
     * @psalm-pure
     */
    public static function rightOpen() : self
    {
        return new self(self::RIGHT_OPEN);
    }

    /**
     * A < x <= B.
     *
     * @psalm-pure
     */
    public static function leftOpen() : self
    {
        return new self(self::LEFT_OPEN);
    }

    /**
     * A < x < B.
     *
     * @psalm-pure
     */
    public static function open() : self
    {
        return new self(self::OPEN);
    }

    public function isOpen() : bool
    {
        return $this->type === self::OPEN;
    }

    public function isLeftOpen() : bool
    {
        return $this->type === self::LEFT_OPEN || $this->type === self::OPEN;
    }

    public function isRightOpen() : bool
    {
        return $this->type === self::RIGHT_OPEN || $this->type === self::OPEN;
    }

    public function isClosed() : bool
    {
        return $this->type === self::CLOSED;
    }
}
