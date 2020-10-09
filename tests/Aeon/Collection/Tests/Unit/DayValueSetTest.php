<?php

declare(strict_types=1);

namespace Aeon\Collection\Tests\Unit;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Collection\DayValue;
use Aeon\Collection\DayValueSet;
use PHPUnit\Framework\TestCase;

final class DayValueSetTest extends TestCase
{
    public function test_set_with_duplicated_days() : void
    {
        $this->expectExceptionMessage('Set does not allow duplicated days, day 2020-01-01 is duplicated');
        $this->expectException(InvalidArgumentException::class);

        new DayValueSet(
            DayValue::createEmpty(Day::fromString('2020-01-01')),
            DayValue::createEmpty(Day::fromString('2020-01-01'))
        );
    }

    public function test_set_with_empty_values() : void
    {
        $set = DayValueSet::createEmpty(Day::fromString('2020-01-01'), Day::fromString('2020-01-10'));

        $this->assertCount(10, $set);
        $this->assertSame(
            [null, null, null, null, null, null, null, null, null, null],
            $set->values()
        );
    }

    public function test_set_map() : void
    {
        $set = DayValueSet::createEmpty(Day::fromString('2020-01-01'), Day::fromString('2020-01-10'));
        $set = $set->map(fn (DayValue $dayValue) : DayValue => new DayValue($dayValue->day(), $dayValue->day()->toString()));

        $this->assertCount(10, $set);
        $this->assertSame(
            [
                '2020-01-01',
                '2020-01-02',
                '2020-01-03',
                '2020-01-04',
                '2020-01-05',
                '2020-01-06',
                '2020-01-07',
                '2020-01-08',
                '2020-01-09',
                '2020-01-10',
            ],
            $set->values()
        );
        $this->assertCount(10, $set->toDays());
    }

    public function test_set_filter() : void
    {
        $set = DayValueSet::createEmpty(Day::fromString('2020-01-01'), Day::fromString('2020-02-29'));
        $filteredSet = $set->filter(fn (DayValue $dayValue) : bool => $dayValue->day()->month()->number() === 1);

        $this->assertCount(31, $filteredSet);
    }

    public function test_set_reduce() : void
    {
        $set = DayValueSet::createWith(Day::fromString('2020-01-01'), Day::fromString('2020-02-29'), 1);
        $numberOfDays = $set->reduce(fn (int $initial, DayValue $dayValue) : int => $initial + 1, 0);

        $this->assertSame(60, $numberOfDays);
    }

    public function test_set_sort_ascending() : void
    {
        $set = new DayValueSet(
            new DayValue(Day::fromString('2020-01-10'), 100),
            new DayValue(Day::fromString('2020-01-01'), 100),
            new DayValue(Day::fromString('2020-01-07'), 100),
            new DayValue(Day::fromString('2020-01-03'), 100),
            new DayValue(Day::fromString('2020-01-05'), 100),
            new DayValue(Day::fromString('2020-01-04'), 100),
            new DayValue(Day::fromString('2020-01-08'), 100),
            new DayValue(Day::fromString('2020-01-02'), 100),
            new DayValue(Day::fromString('2020-01-06'), 100),
            new DayValue(Day::fromString('2020-01-09'), 100),
        );

        $sortedSet = $set->sortAscending();

        $this->assertSame(
            [
                '2020-01-01',
                '2020-01-02',
                '2020-01-03',
                '2020-01-04',
                '2020-01-05',
                '2020-01-06',
                '2020-01-07',
                '2020-01-08',
                '2020-01-09',
                '2020-01-10',
            ],
            $sortedSet->toDays()->map(fn (Day $day) => $day->toString())
        );
        $this->assertSame('2020-01-01', $sortedSet->first()->day()->toString());
        $this->assertSame('2020-01-10', $sortedSet->last()->day()->toString());
    }

    public function test_set_sort_descending() : void
    {
        $set = new DayValueSet(
            new DayValue(Day::fromString('2020-01-10'), 100),
            new DayValue(Day::fromString('2020-01-01'), 100),
            new DayValue(Day::fromString('2020-01-07'), 100),
            new DayValue(Day::fromString('2020-01-03'), 100),
            new DayValue(Day::fromString('2020-01-05'), 100),
            new DayValue(Day::fromString('2020-01-04'), 100),
            new DayValue(Day::fromString('2020-01-08'), 100),
            new DayValue(Day::fromString('2020-01-02'), 100),
            new DayValue(Day::fromString('2020-01-06'), 100),
            new DayValue(Day::fromString('2020-01-09'), 100),
        );

        $sortedSet = $set->sortDescending();

        $this->assertSame(
            \array_reverse([
                '2020-01-01',
                '2020-01-02',
                '2020-01-03',
                '2020-01-04',
                '2020-01-05',
                '2020-01-06',
                '2020-01-07',
                '2020-01-08',
                '2020-01-09',
                '2020-01-10',
            ]),
            $sortedSet->toDays()->map(fn (Day $day) => $day->toString())
        );
    }

    public function test_set_fill_missing_with() : void
    {
        $set = new DayValueSet(
            new DayValue(Day::fromString('2020-01-10'), 20),
            new DayValue(Day::fromString('2020-01-01'), 20),
        );

        $set = $set->put(
            new DayValue(Day::fromString('2020-01-03'), 100),
            new DayValue(Day::fromString('2020-01-05'), 100),
            new DayValue(Day::fromString('2020-01-04'), 100),
        );

        $set = $set->fillMissingWith(50)->sortAscending();

        $this->assertSame(
            [
                0 => 20,
                1 => 50,
                2 => 100,
                3 => 100,
                4 => 100,
                5 => 50,
                6 => 50,
                7 => 50,
                8 => 50,
                9 => 20,
            ],
            $set->values()
        );
    }

    public function test_set_remove() : void
    {
        $set = DayValueSet::createEmpty(Day::fromString('2020-01-01'), Day::fromString('2020-01-31'));
        $set = $set->remove(Day::fromString('2020-01-10'));

        $this->assertCount(30, $set);

        $this->assertFalse($set->has(Day::fromString('2020-01-10')));
    }

    public function test_get_non_existing_day() : void
    {
        $set = DayValueSet::createEmpty(Day::fromString('2020-01-01'), Day::fromString('2020-01-31'));
        $set = $set->remove(Day::fromString('2020-01-10'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('There is no value for day 2020-01-10');

        $this->assertFalse($set->get(Day::fromString('2020-01-10')));
    }
}
