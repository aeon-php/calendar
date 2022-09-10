## [Unreleased] - 2022-09-10

### Added
- [#297](https://github.com/aeon-php/calendar/pull/297) - **Added magic __toString() method to Month.** - [@christian-kolb](https://github.com/christian-kolb)
- [#295](https://github.com/aeon-php/calendar/pull/295) - **Add compareTo method to DateTime, Time, Day, Month and Year** - [@christian-kolb](https://github.com/christian-kolb)
- [#292](https://github.com/aeon-php/calendar/pull/292) - **Added object oriented utility method isMidnight to Time** - [@christian-kolb](https://github.com/christian-kolb)
- [#292](https://github.com/aeon-php/calendar/pull/292) - **Added object oriented utility method isNotMidnight to Time** - [@christian-kolb](https://github.com/christian-kolb)

### Changed
- [#303](https://github.com/aeon-php/calendar/pull/303) - **Reverted phpbench** - [@norberttech](https://github.com/norberttech)
- [#303](https://github.com/aeon-php/calendar/pull/303) - **Updated minimum required PHP8.1 version to 8.1.10** - [@norberttech](https://github.com/norberttech)
- [#291](https://github.com/aeon-php/calendar/pull/291) - **Refactored internal structure of Time, Day, Month, DateTime and TimeZone, so that it's independent from the way it's constructed.** - [@christian-kolb](https://github.com/christian-kolb)

### Fixed
- [#304](https://github.com/aeon-php/calendar/pull/304) - **DateTime::modify** - [@norberttech](https://github.com/norberttech)
- [#304](https://github.com/aeon-php/calendar/pull/304) - **Mutation score requirements and false positive mutants reported** - [@norberttech](https://github.com/norberttech)

### Removed
- [#303](https://github.com/aeon-php/calendar/pull/303) - **Stringable interface from Month class** - [@norberttech](https://github.com/norberttech)

## [1.0.6] - 2022-08-22

### Changed
- [#286](https://github.com/aeon-php/calendar/pull/286) - **Renamed all isEqual methods to isEqualTo** - [@christian-kolb](https://github.com/christian-kolb)
- [#286](https://github.com/aeon-php/calendar/pull/286) - **Renamed all isLessThen/isGreaterThen methods to isBefore/isAfter** - [@christian-kolb](https://github.com/christian-kolb)

### Fixed
- [#287](https://github.com/aeon-php/calendar/pull/287) - **add instead of sub in Day class** - [@norberttech](https://github.com/norberttech)

## [1.0.5] - 2022-08-14

### Changed
- [#282](https://github.com/aeon-php/calendar/pull/282) - **Changed all methods from `plus` to `add` and `minus` to `sub`.** - [@christian-kolb](https://github.com/christian-kolb)
- [#283](https://github.com/aeon-php/calendar/pull/283) - **Skip test failing at php 7.4 due to differences in how PHP is handling timezones** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#284](https://github.com/aeon-php/calendar/pull/284) - **Satisfy infection** - [@norberttech](https://github.com/norberttech)
- [028464](https://github.com/aeon-php/calendar/commit/028464fc8fb56bee909e2f2165caed36a4395bc9) - **failing tests** - [@norberttech](https://github.com/norberttech)

### Updated
- [fe2252](https://github.com/aeon-php/calendar/commit/fe22529b0188edfc4e5ad055c456d087bb014ce4) - **README.md** - [@norberttech](https://github.com/norberttech)
- [46c279](https://github.com/aeon-php/calendar/commit/46c27924b95e35451b3cab4c4693f36069fdfcbc) - **leap seconds, fixed tools plugins setting** - [@norberttech](https://github.com/norberttech)

## [1.0.4] - 2022-01-28

### Changed
- [141ce9](https://github.com/aeon-php/calendar/commit/141ce987deead220d16554ec35dc49d9774e0c50) - **custom workflows into aeon-php reusable workflows** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#214](https://github.com/aeon-php/calendar/pull/214) - **DateTime::isAmbiguous bug at PHP 8.1** - [@norberttech](https://github.com/norberttech)
- [f85300](https://github.com/aeon-php/calendar/commit/f85300cecf3c4037d9609cc17437ff147fd5d1e5) - **PHP versions scope** - [@norberttech](https://github.com/norberttech)

### Updated
- [abef27](https://github.com/aeon-php/calendar/commit/abef27502a926c526eb86a0c04c18b0658113979) - **infection** - [@norberttech](https://github.com/norberttech)

## [1.0.3] - 2022-01-04

### Changed
- [#199](https://github.com/aeon-php/calendar/pull/199) - **memoization of DateTimeImmutable in all date & time elements** - [@norberttech](https://github.com/norberttech)
- [#197](https://github.com/aeon-php/calendar/pull/197) - **Allow php 8.1 tests to fail** - [@norberttech](https://github.com/norberttech)
- [32c28b](https://github.com/aeon-php/calendar/commit/32c28b4ccf931ce9275b10968a727ed36f69d63e) - **Extendend leap seconds expiration date** - [@norberttech](https://github.com/norberttech)

### Fixed
- [32123e](https://github.com/aeon-php/calendar/commit/32123eeb7aae9573d4a79c9279083728c9411e0e) - **failign static analysis** - [@norberttech](https://github.com/norberttech)

## [1.0.2] - 2021-12-06

### Added
- [#185](https://github.com/aeon-php/calendar/pull/185) - **php 8.1 in test suite** - [@norberttech](https://github.com/norberttech)

### Changed
- [#162](https://github.com/aeon-php/calendar/pull/162) - **updated tools** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#162](https://github.com/aeon-php/calendar/pull/162) - **broken tests** - [@norberttech](https://github.com/norberttech)
- [#141](https://github.com/aeon-php/calendar/pull/141) - **possible null value exception in TimePeriods** - [@norberttech](https://github.com/norberttech)

### Updated
- [#180](https://github.com/aeon-php/calendar/pull/180) - **infection** - [@norberttech](https://github.com/norberttech)
- [#180](https://github.com/aeon-php/calendar/pull/180) - **phpstan** - [@norberttech](https://github.com/norberttech)
- [57b17f](https://github.com/aeon-php/calendar/commit/57b17f4c8255661b99cd4cfbbb22b7826cb96b65) - **dependencies, added dependabot auto merge workflow** - [@norberttech](https://github.com/norberttech)

## [1.0.1] - 2021-06-25

### Changed
- [#137](https://github.com/aeon-php/calendar/pull/137) - **Updated leap seconds list expiration date - there will be no new leap second this year** - [@norberttech](https://github.com/norberttech)

## [1.0.0] - 2021-06-06

### Changed
- [2314e1](https://github.com/aeon-php/calendar/commit/2314e1f0cc6b31cefeda76f4df124d9ad26b6787) - **documentation** - [@norberttech](https://github.com/norberttech)
- [a1a7a7](https://github.com/aeon-php/calendar/commit/a1a7a7852e24087557fb7ac47cacfa25e602b4c6) - **php required version constraint** - [@norberttech](https://github.com/norberttech)

## [0.18.0] - 2021-05-01

### Added
- [#121](https://github.com/aeon-php/calendar/pull/121) - **DateTimeIterator** - [@norberttech](https://github.com/norberttech)
- [#121](https://github.com/aeon-php/calendar/pull/121) - **DateTimeIntervalIterator** - [@norberttech](https://github.com/norberttech)
- [#121](https://github.com/aeon-php/calendar/pull/121) - **TimePeriodsIterator** - [@norberttech](https://github.com/norberttech)
- [#121](https://github.com/aeon-php/calendar/pull/121) - **\DateTimeImmutable cache in DateTime, Day, Month classes to improve time periods iteration performance** - [@norberttech](https://github.com/norberttech)

### Changed
- [#121](https://github.com/aeon-php/calendar/pull/121) - **Year::isLeap() uses algorithm instead of DateTimeImmutable** - [@norberttech](https://github.com/norberttech)
- [#121](https://github.com/aeon-php/calendar/pull/121) - **Month::numberOfDays() uses algorithm instead of DateTimeImmutable** - [@norberttech](https://github.com/norberttech)
- [#121](https://github.com/aeon-php/calendar/pull/121) - **updated infection dependency** - [@norberttech](https://github.com/norberttech)

## [0.17.0] - 2021-04-24

### Added
- [#112](https://github.com/aeon-php/calendar/pull/112) - **post install/update composer scripts that installs tools** - [@norberttech](https://github.com/norberttech)

### Changed
- [#117](https://github.com/aeon-php/calendar/pull/117) - **replaced array of Day with DaysIterator in Days class constructor** - [@norberttech](https://github.com/norberttech)
- [#117](https://github.com/aeon-php/calendar/pull/117) - **replaced array of Month with MonthIterator in Months class constructor** - [@norberttech](https://github.com/norberttech)
- [#117](https://github.com/aeon-php/calendar/pull/117) - **Days::since() will always return days in the same order** - [@norberttech](https://github.com/norberttech)
- [#117](https://github.com/aeon-php/calendar/pull/117) - **Months::since() will always return days in the same order** - [@norberttech](https://github.com/norberttech)
- [#116](https://github.com/aeon-php/calendar/pull/116) - **updated tools** - [@norberttech](https://github.com/norberttech)
- [#116](https://github.com/aeon-php/calendar/pull/116) - **adjusted code to the latest static analysis rules** - [@norberttech](https://github.com/norberttech)

### Removed
- [#117](https://github.com/aeon-php/calendar/pull/117) - **ArrayAccess behavior from Days class** - [@norberttech](https://github.com/norberttech)
- [#117](https://github.com/aeon-php/calendar/pull/117) - **ArrayAccess behavior from Months class** - [@norberttech](https://github.com/norberttech)

## [0.16.4] - 2021-04-04

### Added
- [#110](https://github.com/aeon-php/calendar/pull/110) - **Unit::invert() : self** - [@norberttech](https://github.com/norberttech)
- [#110](https://github.com/aeon-php/calendar/pull/110) - **Unit::isNegative() : boolean** - [@norberttech](https://github.com/norberttech)
- [#110](https://github.com/aeon-php/calendar/pull/110) - **validation to DateTime::modify() method to make sure that it only accepts relative time unit string** - [@norberttech](https://github.com/norberttech)

### Changed
- [#110](https://github.com/aeon-php/calendar/pull/110) - **static analyse tools update and fixed new issues** - [@norberttech](https://github.com/norberttech)
- [#107](https://github.com/aeon-php/calendar/pull/107) - **Replaced phive with separated composer.json for tools** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#110](https://github.com/aeon-php/calendar/pull/110) - **add/sub/modify methods when working with RelativeTimeUnit::month will first change the month and then adjust the day** - [@norberttech](https://github.com/norberttech)
- [#110](https://github.com/aeon-php/calendar/pull/110) - **adding negative time unit to DateTime or Day** - [@norberttech](https://github.com/norberttech)
- [#110](https://github.com/aeon-php/calendar/pull/110) - **subtracting negative time unit from DateTime or Day** - [@norberttech](https://github.com/norberttech)

## [0.16.3] - 2021-03-22

### Fixed
- [#106](https://github.com/aeon-php/calendar/pull/106) - **detecting UTC timezone as abbreviation instead of identifier** - [@norberttech](https://github.com/norberttech)

## [0.16.2] - 2021-03-21

### Added
- [#105](https://github.com/aeon-php/calendar/pull/105) - **DateTime::timeZoneAbbreviation method** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#105](https://github.com/aeon-php/calendar/pull/105) - **TimeZone type detection when created from DateTimeZone** - [@norberttech](https://github.com/norberttech)

## [0.16.1] - 2021-02-23

### Added
- [#104](https://github.com/aeon-php/calendar/pull/104) - **possibility to display relative time units in months/year/calendarMonths** - [@norberttech](https://github.com/norberttech)
- [#103](https://github.com/aeon-php/calendar/pull/103) - **possibility to to get time milliseconds from time unit** - [@norberttech](https://github.com/norberttech)
- [#102](https://github.com/aeon-php/calendar/pull/102) - **possibility to get time hours from time unit** - [@norberttech](https://github.com/norberttech)

## [0.16.0] - 2021-02-19

### Fixed
- [#100](https://github.com/aeon-php/calendar/pull/100) - **failing time tests - creating time from relative string** - [@norberttech](https://github.com/norberttech)

### Removed
- [#101](https://github.com/aeon-php/calendar/pull/101) - **Collection namespace** - [@norberttech](https://github.com/norberttech)

## [0.15.0] - 2021-02-04

### Added
- [#99](https://github.com/aeon-php/calendar/pull/99) - **possibility to set current date directly through GregorianCalendarStub constructor** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::add()` method** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::merge()` method** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::sort()` method** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::sortBy()` method** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::first()` method** - [@norberttech](https://github.com/norberttech)
- [#96](https://github.com/aeon-php/calendar/pull/96) - **`TimePeriods::last()` method** - [@norberttech](https://github.com/norberttech)
- [#91](https://github.com/aeon-php/calendar/pull/91) - **static constructors to GregorianCalendarStub** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#98](https://github.com/aeon-php/calendar/pull/98) - **merging abuts time periods** - [@norberttech](https://github.com/norberttech)
- [#97](https://github.com/aeon-php/calendar/pull/97) - **TimePeriods gap detection** - [@norberttech](https://github.com/norberttech)
- [#95](https://github.com/aeon-php/calendar/pull/95) - **breaking time from string test** - [@norberttech](https://github.com/norberttech)

## [0.14.0] - 2021-01-21

### Added
- [#89](https://github.com/aeon-php/calendar/pull/89) - **integration with aeon-php/automation** - [@norberttech](https://github.com/norberttech)

### Changed
- [#89](https://github.com/aeon-php/calendar/pull/89) - **Updated changelog file** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#90](https://github.com/aeon-php/calendar/pull/90) - **TimePeriod::iterate() bug that was ignoring Interval type making possible to iterate over the period in some cases** - [@norberttech](https://github.com/norberttech)
- [#89](https://github.com/aeon-php/calendar/pull/89) - **GitHub Actions cache integration** - [@norberttech](https://github.com/norberttech)
- [#89](https://github.com/aeon-php/calendar/pull/89) - **Failing tests** - [@norberttech](https://github.com/norberttech)

## [0.13.3] - 2021-01-04

### Changed
- [aae10a](https://github.com/aeon-php/calendar/commit/aae10af449f10def5edda9f617760daf9d52cb6a) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#87](https://github.com/aeon-php/calendar/pull/87) - **Extended leap seconds list expiration date** - [@norberttech](https://github.com/norberttech)
- [c7c422](https://github.com/aeon-php/calendar/commit/c7c422385e36d3d41b3b18976f6780f34dc6af0b) - **Small syntax fix in CHANGELOG.md file** - [@norberttech](https://github.com/norberttech)
- [ee80b6](https://github.com/aeon-php/calendar/commit/ee80b6d8d2371d2560fa2b3c38a9fd50a53c0b86) - **version 0.1.0 changelog** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#88](https://github.com/aeon-php/calendar/pull/88) - **Year::fromString method** - [@norberttech](https://github.com/norberttech)

## [0.13.2] - 2020-12-21

### Changed
- [3f9aac](https://github.com/aeon-php/calendar/commit/3f9aac30e5bdcfb7817e9c40f4e789f291f33335) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#86](https://github.com/aeon-php/calendar/pull/86) - **Fix: possibility to crete DateTime from relative format string with timezon** - [@norberttech](https://github.com/norberttech)

## [0.13.1] - 2020-12-21

### Changed
- [ba7996](https://github.com/aeon-php/calendar/commit/ba7996c129c699925f49fc6590f82585aa98bba3) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#85](https://github.com/aeon-php/calendar/pull/85) - **Reverted support for relative dates into toString methods** - [@norberttech](https://github.com/norberttech)

## [0.13.0] - 2020-12-20

### Added
- [#84](https://github.com/aeon-php/calendar/pull/84) - **fromString validation to most of the classes, simplified DateTime and TimeZone API** - [@norberttech](https://github.com/norberttech)

### Changed
- [bb6bc9](https://github.com/aeon-php/calendar/commit/bb6bc9eb8dbcdf8ba99c66ee1f56408806c61464) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#83](https://github.com/aeon-php/calendar/pull/83) - **tools** - [@norberttech](https://github.com/norberttech)
- [#81](https://github.com/aeon-php/calendar/pull/81) - **Moved phpunit to phars** - [@norberttech](https://github.com/norberttech)
- [afbb3d](https://github.com/aeon-php/calendar/commit/afbb3dc5ce4434ebdd87d16030c4921dd628321d) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#79](https://github.com/aeon-php/calendar/pull/79) - **Remove function trailing commas** - [@norberttech](https://github.com/norberttech)
- [#78](https://github.com/aeon-php/calendar/pull/78) - **Run testsuite at php8** - [@norberttech](https://github.com/norberttech)

## [0.12.0] - 2020-11-22

### Added
- [#77](https://github.com/aeon-php/calendar/pull/77) - **possibility to create TimeUnit from date string** - [@norberttech](https://github.com/norberttech)
- [bf05e6](https://github.com/aeon-php/calendar/commit/bf05e64f69afafa4a3a3a6a01356d71229010165) - **link to forum** - [@norberttech](https://github.com/norberttech)

### Changed
- [f12282](https://github.com/aeon-php/calendar/commit/f122821e890fcb8c2bd71ab550e0c2bad51a1982) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)

## [0.11.0] - 2020-10-23

### Added
- [#73](https://github.com/aeon-php/calendar/pull/73) - **__serialize and __unserialize methods to those value objects that might be serialized** - [@norberttech](https://github.com/norberttech)

### Changed
- [c93e22](https://github.com/aeon-php/calendar/commit/c93e225a30b42522a1b3b4b867eaf168886ba4c5) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#75](https://github.com/aeon-php/calendar/pull/75) - **Pass TimeZone into GregorianCalendarStub instead of nullable DateTimeImmutable** - [@norberttech](https://github.com/norberttech)
- [3e1076](https://github.com/aeon-php/calendar/commit/3e10764231df2967bc00b6243be96a1307936745) - **Create dependabot.yml** - [@norberttech](https://github.com/norberttech)

## [0.10.0] - 2020-10-14

### Changed
- [356aef](https://github.com/aeon-php/calendar/commit/356aef6d86dbc5112833826c0c0977e15d5e0db3) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#72](https://github.com/aeon-php/calendar/pull/72) - **Make sure all DateTime constructors create the same instance** - [@norberttech](https://github.com/norberttech)

## [0.9.0] - 2020-10-13

### Added
- [#70](https://github.com/aeon-php/calendar/pull/70) - **possibility to format Time** - [@norberttech](https://github.com/norberttech)

### Changed
- [2c0ca7](https://github.com/aeon-php/calendar/commit/2c0ca7310614807eacab857ba82049b4bd075591) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)

## [0.8.0] - 2020-10-11

### Changed
- [df694a](https://github.com/aeon-php/calendar/commit/df694a58eea9532c3c4cd480dff5dd859ce876cf) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [1ad646](https://github.com/aeon-php/calendar/commit/1ad64637554a01c760254ce4445c60509e203449) - **dependencies** - [@norberttech](https://github.com/norberttech)
- [3cf332](https://github.com/aeon-php/calendar/commit/3cf3329a61473b3344995f804962a7c7ed2dca67) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [90d3af](https://github.com/aeon-php/calendar/commit/90d3afdeff731a1983f78785edabc5954993a634) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#69](https://github.com/aeon-php/calendar/pull/69) - **DateTime offset assertion with correction** - [@norberttech](https://github.com/norberttech)
- [996853](https://github.com/aeon-php/calendar/commit/996853fe7976c6a9be7e5794ba8feb81f140a48a) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#68](https://github.com/aeon-php/calendar/pull/68) - **DayValue Set collection** - [@norberttech](https://github.com/norberttech)

## [0.7.0] - 2020-09-20

### Added
- [#66](https://github.com/aeon-php/calendar/pull/66) - **distance to method to Day/Month/Year/DateTime** - [@norberttech](https://github.com/norberttech)
- [#64](https://github.com/aeon-php/calendar/pull/64) - **possibility to setTime on Day in order to create DateTime** - [@norberttech](https://github.com/norberttech)

### Changed
- [8a2d26](https://github.com/aeon-php/calendar/commit/8a2d26e06c0fd696922682d8f080abf16a5d383b) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [e3add2](https://github.com/aeon-php/calendar/commit/e3add290a1552a253d6d47ea7c8226339f1e180a) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#67](https://github.com/aeon-php/calendar/pull/67) - **Unified Day/Month/Year and DateTime interval methods** - [@norberttech](https://github.com/norberttech)
- [a5a938](https://github.com/aeon-php/calendar/commit/a5a938a0bebd04365ec5dac197afc2998d0e45d9) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [231e86](https://github.com/aeon-php/calendar/commit/231e86d635d685ddc7ad756420e8643fb184f145) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#63](https://github.com/aeon-php/calendar/pull/63) - **TimeUnit - modulo** - [@norberttech](https://github.com/norberttech)

## [0.6.0] - 2020-09-04

### Added
- [#62](https://github.com/aeon-php/calendar/pull/62) - **possibility to merge overlapping time periods** - [@norberttech](https://github.com/norberttech)
- [#61](https://github.com/aeon-php/calendar/pull/61) - **possibility to check if one time period contains other** - [@norberttech](https://github.com/norberttech)
- [#60](https://github.com/aeon-php/calendar/pull/60) - **possibility to iterate by relative time units like months/years** - [@norberttech](https://github.com/norberttech)
- [#59](https://github.com/aeon-php/calendar/pull/59) - **add/sub methods to Time** - [@norberttech](https://github.com/norberttech)
- [#58](https://github.com/aeon-php/calendar/pull/58) - **Quarter** - [@norberttech](https://github.com/norberttech)
- [#57](https://github.com/aeon-php/calendar/pull/57) - **toNegative toPositive method to TimeUnit** - [@norberttech](https://github.com/norberttech)
- [#56](https://github.com/aeon-php/calendar/pull/56) - **possibility to define type of the interval when iterating over time periods** - [@norberttech](https://github.com/norberttech)
- [#53](https://github.com/aeon-php/calendar/pull/53) - **DateTime::setTimeIn method** - [@norberttech](https://github.com/norberttech)

### Changed
- [cf0c81](https://github.com/aeon-php/calendar/commit/cf0c81d8a5ad6a48cf79a309682bc45565b5200b) - **Prepared changelog for 0.6.0 release & updated dependencies** - [@norberttech](https://github.com/norberttech)
- [b4901b](https://github.com/aeon-php/calendar/commit/b4901ba601d26efa6cc28f188a63ca14aac7aee6) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [e999da](https://github.com/aeon-php/calendar/commit/e999dae5d6365c9fd87d8afd21a8c8db5fc31864) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [59fcea](https://github.com/aeon-php/calendar/commit/59fcea7415d2d356da33ed3f8d1d0e1e2245d903) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [a1f8f5](https://github.com/aeon-php/calendar/commit/a1f8f541e5010f8d93581a218ce41425258358aa) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [a1caea](https://github.com/aeon-php/calendar/commit/a1caead13b1ba134f3f7738f88469cebed2bb96c) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [ccf733](https://github.com/aeon-php/calendar/commit/ccf733a961f68963c023ccd042ed14ff7533768a) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#55](https://github.com/aeon-php/calendar/pull/55) - **phive tools** - [@norberttech](https://github.com/norberttech)
- [2ae0f7](https://github.com/aeon-php/calendar/commit/2ae0f7440aeed6004c51d455e5ed8c8e32bb88d9) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)

### Removed
- [581ad9](https://github.com/aeon-php/calendar/commit/581ad96d16fd92ac83f9a85cafcf703002686e59) - **unnecessary docblocks** - [@norberttech](https://github.com/norberttech)

## [0.5.0] - 2020-08-24

### Added
- [#52](https://github.com/aeon-php/calendar/pull/52) - **psalm-pure for static factory methods** - [@tomaszhanc](https://github.com/tomaszhanc)

### Changed
- [8dd66a](https://github.com/aeon-php/calendar/commit/8dd66af0e646f40dd2ab9251352f7e8e65b78e27) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [f9fd2e](https://github.com/aeon-php/calendar/commit/f9fd2ea319e4f7e6cc6688d24c5745972246bf5b) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)

## [0.4.0] - 2020-08-15

### Added
- [#51](https://github.com/aeon-php/calendar/pull/51) - **DateTime setTime and setDay methods** - [@norberttech](https://github.com/norberttech)

### Changed
- [c082cc](https://github.com/aeon-php/calendar/commit/c082ccd33577bb8a67b6c2218d888fc4907785a4) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [800302](https://github.com/aeon-php/calendar/commit/8003029212acf211d635d3b49b93affbec7379fa) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [769f91](https://github.com/aeon-php/calendar/commit/769f91a12f173d846e53d02c42e2d65a340c3abf) - **phpunit dependency to ^9.3 (#49)** - [@norberttech](https://github.com/norberttech)
- [69eda4](https://github.com/aeon-php/calendar/commit/69eda42c65d5dc35f0a0a1ef64be135489690c8b) - **Update README.md** - [@norberttech](https://github.com/norberttech)
- [d93c04](https://github.com/aeon-php/calendar/commit/d93c047caa61f3b02e42020a53d96f407c53a2c3) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [39d3c2](https://github.com/aeon-php/calendar/commit/39d3c273a7dd41c00c27b0150879dba6354b8d27) - **Moved tools into phive (#48)** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#50](https://github.com/aeon-php/calendar/pull/50) - **phive dependnecies** - [@norberttech](https://github.com/norberttech)

### Removed
- [834fdf](https://github.com/aeon-php/calendar/commit/834fdff5a0f0cab3f26664edcb725d1e3f8b0e17) - **phive tools from repository** - [@norberttech](https://github.com/norberttech)

## [0.3.0] - 2020-08-01

### Added
- [8c7c73](https://github.com/aeon-php/calendar/commit/8c7c73bad7b141befbdaaee3b887cb5339e85deb) - **mutation score badge** - [@norberttech](https://github.com/norberttech)
- [1bdc34](https://github.com/aeon-php/calendar/commit/1bdc34634074b427106dbc357b668d4044e65084) - **infection badge configuration code** - [@norberttech](https://github.com/norberttech)
- [#43](https://github.com/aeon-php/calendar/pull/43) - **CS fixer to benchmarks code, added new benchmark** - [@norberttech](https://github.com/norberttech)

### Changed
- [fcf6af](https://github.com/aeon-php/calendar/commit/fcf6af31d67439ea23bb56c64a29769028fdf133) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#48](https://github.com/aeon-php/calendar/pull/48) - **Moved tools into phive** - [@norberttech](https://github.com/norberttech)
- [2c6c6a](https://github.com/aeon-php/calendar/commit/2c6c6af2004b3c81ae356ee14cf4c0403e113194) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [ee0d4a](https://github.com/aeon-php/calendar/commit/ee0d4a4f8d18c85d48efd59b86a7c40ae075d436) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [ababd1](https://github.com/aeon-php/calendar/commit/ababd10fed3666a26a5ad9d32f552c7f97f29ec2) - **error level to totallyTyped in psalm config** - [@norberttech](https://github.com/norberttech)
- [#47](https://github.com/aeon-php/calendar/pull/47) - **Increased required infection MSI % to 100%** - [@norberttech](https://github.com/norberttech)
- [#46](https://github.com/aeon-php/calendar/pull/46) - **Optimize datetime static constructor** - [@norberttech](https://github.com/norberttech)
- [13f334](https://github.com/aeon-php/calendar/commit/13f33474d3312fc14f2f14900d892896eed9cd7f) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#45](https://github.com/aeon-php/calendar/pull/45) - **Implementation of static create method for Day and Month classes #41** - [@eamirgh](https://github.com/eamirgh)
- [#44](https://github.com/aeon-php/calendar/pull/44) - **TimePeriod::overlaps performance improvements** - [@norberttech](https://github.com/norberttech)
- [#42](https://github.com/aeon-php/calendar/pull/42) - **Performance optimizations** - [@norberttech](https://github.com/norberttech)
- [#40](https://github.com/aeon-php/calendar/pull/40) - **created difference betweenDays static method issue #34** - [@eamirgh](https://github.com/eamirgh)
- [85592f](https://github.com/aeon-php/calendar/commit/85592fad868e509b11b1b3113e0dedf658319ca9) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#39](https://github.com/aeon-php/calendar/pull/39) - **Renamed equals to isEqual method fix issue #38** - [@eamirgh](https://github.com/eamirgh)

## [0.2.0] - 2020-07-16

### Added
- [#37](https://github.com/aeon-php/calendar/pull/37) - **Year/Month/Day manipulation and comparison methods** - [@norberttech](https://github.com/norberttech)

### Changed
- [438357](https://github.com/aeon-php/calendar/commit/4383572133352c54688bdd7144c6541a7598295a) - **Update CHANGELOG.md** - [@norberttech](https://github.com/norberttech)
- [#35](https://github.com/aeon-php/calendar/pull/35) - **Update README.md** - [@norberttech](https://github.com/norberttech)

## [0.1.0] - 2020-07-10

### Added
- [da0770](https://github.com/aeon-php/calendar/commit/da07703d5c025be1da16229ac4d1d243926e297c) - **changlog file** - [@norberttech](https://github.com/norberttech)
- [a3b8b6](https://github.com/aeon-php/calendar/commit/a3b8b6f0803377efe4e7d4aacd0b92ce6c18dc69) - **one missing test for extended iso8601 format** - [@norberttech](https://github.com/norberttech)
- [#29](https://github.com/aeon-php/calendar/pull/29) - **extra features to TimePeriod and TimePeriods** - [@norberttech](https://github.com/norberttech)
- [#27](https://github.com/aeon-php/calendar/pull/27) - **more precised php cs fixer rules** - [@norberttech](https://github.com/norberttech)
- [#24](https://github.com/aeon-php/calendar/pull/24) - **possibility to multiply/divide TimeUnit** - [@norberttech](https://github.com/norberttech)
- [#21](https://github.com/aeon-php/calendar/pull/21) - **possibility to detect ambiguous local time** - [@norberttech](https://github.com/norberttech)
- [5cf8ba](https://github.com/aeon-php/calendar/commit/5cf8babba8f2e8fb5495fecc5ee25f56b220e20c) - **psalm/phpstan cache, fixed DateTime timezone assertions** - [@norberttech](https://github.com/norberttech)
- [#19](https://github.com/aeon-php/calendar/pull/19) - **helper methods to Stopwatch class** - [@norberttech](https://github.com/norberttech)
- [#16](https://github.com/aeon-php/calendar/pull/16) - **Stopwatch class built on top of php \hrtime function** - [@norberttech](https://github.com/norberttech)
- [#15](https://github.com/aeon-php/calendar/pull/15) - **possibility to create DateTime from primitives and fixed related bug** - [@norberttech](https://github.com/norberttech)
- [#12](https://github.com/aeon-php/calendar/pull/12) - **DateTime::secondsSinceUnixEpochPrecise() : float method used later in TimePeriod::distance** - [@norberttech](https://github.com/norberttech)
- [29c558](https://github.com/aeon-php/calendar/commit/29c558f737e17e2dac9a2e30857c3e363d68a5bb) - **branch aliast and minimum stability** - [@norberttech](https://github.com/norberttech)
- [b19db0](https://github.com/aeon-php/calendar/commit/b19db0d696f866e392b977abab0649105e9bd08f) - **missing immutable annotation to Calendar interface** - [@norberttech](https://github.com/norberttech)
- [#9](https://github.com/aeon-php/calendar/pull/9) - **possibility to filter TimeIntervals** - [@norberttech](https://github.com/norberttech)
- [#8](https://github.com/aeon-php/calendar/pull/8) - **week of month number to Day class** - [@norberttech](https://github.com/norberttech)
- [#7](https://github.com/aeon-php/calendar/pull/7) - **possibility to compare Time objects** - [@norberttech](https://github.com/norberttech)
- [#5](https://github.com/aeon-php/calendar/pull/5) - **possibility to convert DateInterval into TimeUnit** - [@norberttech](https://github.com/norberttech)
- [#3](https://github.com/aeon-php/calendar/pull/3) - **DateTime::modify(string ) : DateTime method** - [@norberttech](https://github.com/norberttech)
- [#2](https://github.com/aeon-php/calendar/pull/2) - **leap years test** - [@norberttech](https://github.com/norberttech)
- [5e79a2](https://github.com/aeon-php/calendar/commit/5e79a20ceacd58bbb00e619d9db913ff4b359865) - **doctrine types extension to readme** - [@norberttech](https://github.com/norberttech)
- [fccbb5](https://github.com/aeon-php/calendar/commit/fccbb579f1ffced56c952506475e4e2ec1423298) - **extensions to README** - [@norberttech](https://github.com/norberttech)
- [f35cba](https://github.com/aeon-php/calendar/commit/f35cbab84ba7849e2a54c16f71aee8588b32affe) - **examples to readme** - [@norberttech](https://github.com/norberttech)
- [77e95b](https://github.com/aeon-php/calendar/commit/77e95bbbb2eaa7c4b1ebb6ed176d6ce04ab80c59) - **github workflows** - [@norberttech](https://github.com/norberttech)
- [47f4b5](https://github.com/aeon-php/calendar/commit/47f4b5bc44d01383529d096b92aa90b0b3decea4) - **php stricted dependency** - [@norberttech](https://github.com/norberttech)
- [51c10c](https://github.com/aeon-php/calendar/commit/51c10cd2586668e44153dcfa493864935b6fdda1) - **infection mutation testing framework** - [@norberttech](https://github.com/norberttech)
- [448d7d](https://github.com/aeon-php/calendar/commit/448d7daf22785f0f34d6bf598d0f6bfd572b8d30) - **missing README, License files, php cs fixer and gitattributes** - [@norberttech](https://github.com/norberttech)
- [a1d444](https://github.com/aeon-php/calendar/commit/a1d4449ff6f35e300fcf4c16624a7ab18c771f81) - **possibility to iterate/filter days and months** - [@norberttech](https://github.com/norberttech)
- [e02f32](https://github.com/aeon-php/calendar/commit/e02f32c265822a3ad937f1143d4afb67c941fbdd) - **Process abstraction with SystemProcess implementation that makes easier to sleep/usleep in the code** - [@norberttech](https://github.com/norberttech)
- [520bb2](https://github.com/aeon-php/calendar/commit/520bb2ace1112276227d16b0d50bf1ae056bd674) - **until method to DateTime** - [@norberttech](https://github.com/norberttech)
- [0606e7](https://github.com/aeon-php/calendar/commit/0606e734432407d9023be5145a88f2ca15611412) - **Holidays abstraction with GoogleCalendarRegionalHolidays implementation** - [@norberttech](https://github.com/norberttech)
- [1607e8](https://github.com/aeon-php/calendar/commit/1607e86481c1e97c323854d363ec5d835f038fd9) - **functional tests** - [@norberttech](https://github.com/norberttech)
- [46a181](https://github.com/aeon-php/calendar/commit/46a1819518b0576998d5ab80a5adeab2844b2c36) - **more tests to day** - [@norberttech](https://github.com/norberttech)
- [e00f6c](https://github.com/aeon-php/calendar/commit/e00f6ccb3b9c28e0a12b81646c52d415dd46a4cf) - **timezone abstraction** - [@norberttech](https://github.com/norberttech)
- [293ec0](https://github.com/aeon-php/calendar/commit/293ec073d96d343f3cb1909d8ad7de4e5cc04719) - **more descriptive debug info to each class** - [@norberttech](https://github.com/norberttech)
- [32469a](https://github.com/aeon-php/calendar/commit/32469a538f7e1ed91e10b0b7cbccb2a975c96d96) - **DateTime to string method** - [@norberttech](https://github.com/norberttech)
- [95c1ca](https://github.com/aeon-php/calendar/commit/95c1cab47df1510f91ae858b3c39bc9437ebeda1) - **more tests and removed timezone from Time class - time is relative** - [@norberttech](https://github.com/norberttech)
- [d01ad3](https://github.com/aeon-php/calendar/commit/d01ad315db95191be7e0f2ac2126f3a99ac9aa65) - **add/sub methods to DateTime** - [@norberttech](https://github.com/norberttech)
- [8448b2](https://github.com/aeon-php/calendar/commit/8448b22ea5a0dfd23db131c939bc44ca38e7a0a9) - **basic concept of TimeUnit and Period** - [@norberttech](https://github.com/norberttech)
- [68263a](https://github.com/aeon-php/calendar/commit/68263a392973521bb81606deeab253d0fdc50eb5) - **assertion** - [@norberttech](https://github.com/norberttech)

### Changed
- [fb8454](https://github.com/aeon-php/calendar/commit/fb8454b381df974b40ca2c374cc3f0afe9e7b25e) - **dev dependencies** - [@norberttech](https://github.com/norberttech)
- [#31](https://github.com/aeon-php/calendar/pull/31) - **Improved toISO8601 DateTime conversion** - [@norberttech](https://github.com/norberttech)
- [#30](https://github.com/aeon-php/calendar/pull/30) - **Use bcmath to compare TimeUnits** - [@norberttech](https://github.com/norberttech)
- [#25](https://github.com/aeon-php/calendar/pull/25) - **Make sure that DateTime methods endOfDay, noon and midnight dont reset the timezone** - [@norberttech](https://github.com/norberttech)
- [#22](https://github.com/aeon-php/calendar/pull/22) - **Resolve bug in datetime object creation** - [@norberttech](https://github.com/norberttech)
- [#18](https://github.com/aeon-php/calendar/pull/18) - **Stopwatch class API** - [@norberttech](https://github.com/norberttech)
- [242ef8](https://github.com/aeon-php/calendar/commit/242ef84dabad263ae6d8920f4f2644d48d90befc) - **dev-master with dev-latest branch alias** - [@norberttech](https://github.com/norberttech)
- [427df1](https://github.com/aeon-php/calendar/commit/427df114488cb53100aed488bfdd8b07d7442268) - **Reduced webmozart/assert dependency to ^1.3** - [@norberttech](https://github.com/norberttech)
- [#17](https://github.com/aeon-php/calendar/pull/17) - **Leap seconds support** - [@norberttech](https://github.com/norberttech)
- [7e13b5](https://github.com/aeon-php/calendar/commit/7e13b569e90dbd9da3a3295054d4aeecf16458b1) - **Schedule tests with github actions** - [@norberttech](https://github.com/norberttech)
- [#14](https://github.com/aeon-php/calendar/pull/14) - **Reset time when converging Year, Month and Day to DateTimeImmutable** - [@norberttech](https://github.com/norberttech)
- [#10](https://github.com/aeon-php/calendar/pull/10) - **Remove minimum stability dev** - [@norberttech](https://github.com/norberttech)
- [06dc87](https://github.com/aeon-php/calendar/commit/06dc87c9ee545ce97a5a9a89c775ab6efb2ec5ee) - **dependencies** - [@norberttech](https://github.com/norberttech)
- [94e4d0](https://github.com/aeon-php/calendar/commit/94e4d06d7985cddb1cbdcc1679224b21f1670b2a) - **Update README.md** - [@norberttech](https://github.com/norberttech)
- [2c346a](https://github.com/aeon-php/calendar/commit/2c346af9f835c7203b8d7cc655ee618e377595eb) - **Marked few more constructors as pure** - [@norberttech](https://github.com/norberttech)
- [#6](https://github.com/aeon-php/calendar/pull/6) - **Allow to use DateTimeInterface to create Aeon objects** - [@norberttech](https://github.com/norberttech)
- [#1](https://github.com/aeon-php/calendar/pull/1) - **Extracted week day to standalone class** - [@norberttech](https://github.com/norberttech)
- [4b469d](https://github.com/aeon-php/calendar/commit/4b469de51b274925d450158cbc496964b4425cd8) - **php dependency** - [@norberttech](https://github.com/norberttech)
- [8f8e25](https://github.com/aeon-php/calendar/commit/8f8e2584f1bba4e5c07dbbe02a8c7ce9c67d9ee8) - **Extracted process to aeon-php/process repostory** - [@norberttech](https://github.com/norberttech)
- [bd8b1f](https://github.com/aeon-php/calendar/commit/bd8b1f9205a7e42662bbb183c26585bed8214444) - **Extracted Holidays to standalone repository** - [@norberttech](https://github.com/norberttech)
- [f7012d](https://github.com/aeon-php/calendar/commit/f7012d8d8d51bf8e3251a0e505fa656a6cff60e2) - **Dont execute mutation tests and static analze tests at windows** - [@norberttech](https://github.com/norberttech)
- [ccf7ab](https://github.com/aeon-php/calendar/commit/ccf7abb5fb6b1dbdf8515cc30bebd47447349247) - **Configured php cs fixer and added it to composer test script** - [@norberttech](https://github.com/norberttech)
- [e2b39d](https://github.com/aeon-php/calendar/commit/e2b39d21205b5c2b9ce54b365bee55012a439d37) - **Increased threads and min coverage for infection** - [@norberttech](https://github.com/norberttech)
- [d028a2](https://github.com/aeon-php/calendar/commit/d028a2bffb8f11392d06d37267cc4b894e7f756d) - **composer.json tags** - [@norberttech](https://github.com/norberttech)
- [c3c1f7](https://github.com/aeon-php/calendar/commit/c3c1f7f20e2b096229963af72f329ceb7687a910) - **Reduced timeout for infection tests** - [@norberttech](https://github.com/norberttech)
- [b279f5](https://github.com/aeon-php/calendar/commit/b279f57c8b6298fd8e05ada3eac3b7b211859ddb) - **Moved to Aeon namespace** - [@norberttech](https://github.com/norberttech)
- [c78baf](https://github.com/aeon-php/calendar/commit/c78baf31ad214494f40d754ce38e310e9595727a) - **Set code coverage to 100%** - [@norberttech](https://github.com/norberttech)
- [e98306](https://github.com/aeon-php/calendar/commit/e98306b694dac6fcdb65484494126d299efd0f6c) - **Increase test coverage** - [@norberttech](https://github.com/norberttech)
- [8bec05](https://github.com/aeon-php/calendar/commit/8bec0529bb3bb9af76616fcb91a3acbe4bd787dc) - **Moved Holiday namespace under Gregorian Calendar** - [@norberttech](https://github.com/norberttech)
- [0cfd6e](https://github.com/aeon-php/calendar/commit/0cfd6e350ee91524158400a4eba45a86fba261d2) - **Introduced TimeOffset to DateTime** - [@norberttech](https://github.com/norberttech)
- [5cc1af](https://github.com/aeon-php/calendar/commit/5cc1af5093eb08aaebe7165abe9a61d67768ebcd) - **Don't enforce en as default locale** - [@norberttech](https://github.com/norberttech)
- [31ac5c](https://github.com/aeon-php/calendar/commit/31ac5c6f7ffc4fae4f50976d355b21c277749895) - **Intervals in iterating backward should have negative time unit** - [@norberttech](https://github.com/norberttech)
- [820d26](https://github.com/aeon-php/calendar/commit/820d2661322977e8a412cce4c1f5e75e06263ea0) - **Move namespace of Gregorian calendar** - [@norberttech](https://github.com/norberttech)
- [a3c4d7](https://github.com/aeon-php/calendar/commit/a3c4d77e2b852656986c74800ad7d598aae570ad) - **TimeIntervals and TimePeriod iterate and iterateBackward** - [@norberttech](https://github.com/norberttech)
- [684144](https://github.com/aeon-php/calendar/commit/68414449ca32c6be841ebf384db5529402523b7d) - **Renamed TZ offset method** - [@norberttech](https://github.com/norberttech)
- [09da4c](https://github.com/aeon-php/calendar/commit/09da4c468a8838b45623c045e54308d195700e4e) - **Renamed Period to TimePeriod** - [@norberttech](https://github.com/norberttech)
- [6609ef](https://github.com/aeon-php/calendar/commit/6609ef980990efd8bb2e62a1bc5ddd0225efab4b) - **Initial commit** - [@norberttech](https://github.com/norberttech)

### Fixed
- [7a2d94](https://github.com/aeon-php/calendar/commit/7a2d940abab698442551abfdea510c1e90234640) - **InvalidArgumentException parent class** - [@norberttech](https://github.com/norberttech)
- [#28](https://github.com/aeon-php/calendar/pull/28) - **issue where for certain Day class methods timezone was implicitly set to UTC** - [@norberttech](https://github.com/norberttech)
- [080471](https://github.com/aeon-php/calendar/commit/080471eaacc6348d477ff372e5066fc8ab59279b) - **phpdoc align CS rule** - [@norberttech](https://github.com/norberttech)
- [#20](https://github.com/aeon-php/calendar/pull/20) - **distance since/until functions at DateTime** - [@norberttech](https://github.com/norberttech)
- [aea12e](https://github.com/aeon-php/calendar/commit/aea12ee59ba7cdf1cecafcd976df206d81bef26f) - **github workflows** - [@norberttech](https://github.com/norberttech)
- [#4](https://github.com/aeon-php/calendar/pull/4) - **precision in DateTime::sub DateTime::add methods** - [@norberttech](https://github.com/norberttech)
- [6f40f9](https://github.com/aeon-php/calendar/commit/6f40f9a82ec87f7e04be3fe891bc32088c3ce419) - **distance backward in time period** - [@norberttech](https://github.com/norberttech)
- [280bb6](https://github.com/aeon-php/calendar/commit/280bb6a62db3a15304b39532bb36aff6aa1fe247) - **calculating distance with microseconds precision** - [@norberttech](https://github.com/norberttech)
- [ba80b6](https://github.com/aeon-php/calendar/commit/ba80b64bb569c2656bd255f9499446ff4ab1226b) - **TimeUnit comparision** - [@norberttech](https://github.com/norberttech)
- [fb3764](https://github.com/aeon-php/calendar/commit/fb3764bcb290ee08f9452852e322bd8699b81297) - **precision calculation and made GregorianCalendar dependent on timezone** - [@norberttech](https://github.com/norberttech)
- [1807ec](https://github.com/aeon-php/calendar/commit/1807ecd3ff63a9710f0f8270c4d03fcfdfa500a3) - **folder** - [@norberttech](https://github.com/norberttech)
- [3f9b64](https://github.com/aeon-php/calendar/commit/3f9b64c3056aedff0cc2dd369b8cba776a51eb9e) - **Namespace** - [@norberttech](https://github.com/norberttech)
- [926761](https://github.com/aeon-php/calendar/commit/9267619befe793ef7eefd39af412e09201d75250) - **calendar stub** - [@norberttech](https://github.com/norberttech)
- [95539b](https://github.com/aeon-php/calendar/commit/95539b8311040c02ffdf78a47d17fed0c88d614f) - **usage of psalm immutable** - [@norberttech](https://github.com/norberttech)

### Removed
- [#26](https://github.com/aeon-php/calendar/pull/26) - **webmozart/assert dependnecy** - [@norberttech](https://github.com/norberttech)
- [e0734c](https://github.com/aeon-php/calendar/commit/e0734cba2f46a9e5f4a34486ce54e92c09ceb17f) - **branch alias** - [@norberttech](https://github.com/norberttech)
- [53feef](https://github.com/aeon-php/calendar/commit/53feef44b81f97ebe466a07c8188a300dbcb70b3) - **useless interfaces** - [@norberttech](https://github.com/norberttech)
- [#11](https://github.com/aeon-php/calendar/pull/11) - **redundant TimeInterval and renamed TimeIntervals into TimePeriods** - [@norberttech](https://github.com/norberttech)
- [39bd2d](https://github.com/aeon-php/calendar/commit/39bd2df885f19dc4189cc0453c045f0f651037c8) - **unused use statements** - [@norberttech](https://github.com/norberttech)
- [c4ac79](https://github.com/aeon-php/calendar/commit/c4ac797e3f959ae1a5dc427c90880a2aca8e16c7) - **unsued use statements** - [@norberttech](https://github.com/norberttech)
- [527669](https://github.com/aeon-php/calendar/commit/527669f147ef2f55eb728213aca695de39124c56) - **composer lock from gitignore, added psalm immutable annotation to calendar interface** - [@norberttech](https://github.com/norberttech)

Generated by [Automation](https://github.com/aeon-php/automation)