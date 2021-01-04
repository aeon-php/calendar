# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Types of changes:
- `Added` for new features.
- `Changed` for changes in existing functionality.
- `Deprecated` for soon-to-be removed features.
- `Removed` for now removed features.
- `Fixed` for any bug fixes.
- `Security` in case of vulnerabilities.

## Unreleased

## [0.13.3] - 2021-01-04

### Changed
  - [#87](https://github.com/aeon-php/calendar/pull/87) - **Extended leap seconds list expiration date** - [@norberttech](https://github.com/norberttech)
  - [c7c422](https://github.com/aeon-php/calendar/commit/c7c422385e36d3d41b3b18976f6780f34dc6af0b) - **Small syntax fix in CHANGELOG.md file** - [@norberttech](https://github.com/norberttech)
  - [ee80b6](https://github.com/aeon-php/calendar/commit/ee80b6d8d2371d2560fa2b3c38a9fd50a53c0b86) - **version 0.1.0 changelog** - [@norberttech](https://github.com/norberttech)

### Fixed
  - [#88](https://github.com/aeon-php/calendar/pull/88) - **Year::fromString method** - [@norberttech](https://github.com/norberttech)

## [0.13.2] - 2020-12-22
### Fixed
- [#86](https://github.com/aeon-php/calendar/pull/86) - **Fix: possibility to crete DateTime from relative format string with timezon #86** - [@norberttech](https://github.com/norberttech)

## [0.13.1] - 2020-12-21
### Fixed
- [#84](https://github.com/aeon-php/calendar/pull/84) - **Restored support for relative dates into toString methods #85** - [@norberttech](https://github.com/norberttech)

## [0.13.0] - 2020-12-20
### Added
- [#84](https://github.com/aeon-php/calendar/pull/84) - **Added fromString validation to most of the classes, simplified DateTime and TimeZone API #84** - [@norberttech](https://github.com/norberttech)
  - Validation to all fromString methods that are using date/time format
  - Type to TimeZone (offset, abbreviation, identifier)
  - More benchmarks
  - TimeZone abbreviation static constructors
  - TimeZone allIdentifiers() allAbbreviations() methods
- [#78](https://github.com/aeon-php/calendar/pull/78) - **Run testsuite at php8 #78** - [@norberttech](https://github.com/norberttech)

### Changed
- [#84](https://github.com/aeon-php/calendar/pull/84) - **Added fromString validation to most of the classes, simplified DateTime and TimeZone API #84** - [@norberttech](https://github.com/norberttech)
  - TimeZone to mandatory argument of DateTime
  - TimeZone new replaced with TimeZone fromString()
- [#83](https://github.com/aeon-php/calendar/pull/83) - **Updated tools #81** - [@norberttech](https://github.com/norberttech)
- [#81](https://github.com/aeon-php/calendar/pull/81) - **Moved phpunit to phars #81** - [@norberttech](https://github.com/norberttech)

### Removed
- [#84](https://github.com/aeon-php/calendar/pull/84) - **Added fromString validation to most of the classes, simplified DateTime and TimeZone API #84** - [@norberttech](https://github.com/norberttech)
  - Offset from DateTime object
  - TimeZone identifiers constants
  - TimeZone toCountryCode method
  - Internal \DateTimeImmutable object from DateTime
  - Possibility to create DateTime object from string without providing valid date
- [#79](https://github.com/aeon-php/calendar/pull/79) - **Remove function trailing commas #79** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#84](https://github.com/aeon-php/calendar/pull/84) - **Added fromString validation to most of the classes, simplified DateTime and TimeZone API #84** - [@norberttech](https://github.com/norberttech)
  - Tests failing around midnight on machines with default timezone different than UTC
  
## [0.12.0] - 2020-11-22
### Added
- [#77](https://github.com/aeon-php/calendar/pull/77) - **Added possibility to create TimeUnit from date string #77** - [@norberttech](https://github.com/norberttech)

## [0.11.0] - 2020-10-23
### Changed 
- [#75](https://github.com/aeon-php/calendar/pull/75) - **Pass TimeZone into GregorianCalendarStub instead of nullable DateTimeImmutable #75** - [@norberttech](https://github.com/norberttech)

### Added
- [#73](https://github.com/aeon-php/calendar/pull/73) - **Added __serialize and __unserialize methods to those value objects that might be serialized #73** - [@norberttech](https://github.com/norberttech)

## [0.10.0] - 2020-10-14
### Fixed
- [#72](https://github.com/aeon-php/calendar/pull/72) - **Make sure all DateTime constructors create the same instance #72** - [@norberttech](https://github.com/norberttech)

## [0.9.0] - 2020-10-13
### Added
- [#70](https://github.com/aeon-php/calendar/pull/70) - **Added possibility to format Time** - [@norberttech](https://github.com/norberttech)

## [0.8.0] - 2020-10-11
### Added
- [#68](https://github.com/aeon-php/calendar/pull/68) - **DayValue Set collection** - [@norberttech](https://github.com/norberttech)

### Fixed
- [#69](https://github.com/aeon-php/calendar/pull/69) - **Replaced DateTime offset assertion with offset correction** - [@norberttech](https://github.com/norberttech)

## [0.7.0] - 2020-09-20
### Added
- [#66](https://github.com/aeon-php/calendar/pull/66) - **Added distance to method to Day/Month/Year/DateTime** - [@norberttech](https://github.com/norberttech)
- [#64](https://github.com/aeon-php/calendar/pull/64) - **Added possibility to setTime on Day in order to create DateTime** - [@norberttech](https://github.com/norberttech)
- [#63](https://github.com/aeon-php/calendar/pull/63) - **TimeUnit added modulo and isZero methods** - [@norberttech](https://github.com/norberttech)

### Changed
- [#67](https://github.com/aeon-php/calendar/pull/67) - **Unified Day/Month/Year and DateTime interval method** - [@norberttech](https://github.com/norberttech)
- [#63](https://github.com/aeon-php/calendar/pull/63) - **Unified TimeUnit multiply/divide arguments** - [@norberttech](https://github.com/norberttech)

## [0.6.0] - 2020-09-04
### Changed
- [#56](https://github.com/aeon-php/calendar/pull/56) - **Added possibility to define type of the interval when iterating over time periods** - [@norberttech](https://github.com/norberttech)
- [#55](https://github.com/aeon-php/calendar/pull/55) - **Updated phive dependencies** - [@norberttech](https://github.com/norberttech)

### Added 
- [#62](https://github.com/aeon-php/calendar/pull/62) - **Added possibility to merge overlapping time periods** - [@norberttech](https://github.com/norberttech)
- [#61](https://github.com/aeon-php/calendar/pull/61) - **Added possibility to check if one time period contains other** - [@norberttech](https://github.com/norberttech)
- [#60](https://github.com/aeon-php/calendar/pull/60) - **Added possibility to iterate by relative time units like months/years** - [@norberttech](https://github.com/norberttech)
- [#59](https://github.com/aeon-php/calendar/pull/59) - **Added add/sub methods to Time** - [@norberttech](https://github.com/norberttech)
- [#58](https://github.com/aeon-php/calendar/pull/58) - **Added Quarters** - [@norberttech](https://github.com/norberttech)
- [#57](https://github.com/aeon-php/calendar/pull/57) - **Added toNegative toPositive method to TimeUnit** - [@norberttech](https://github.com/norberttech)
- [#53](https://github.com/aeon-php/calendar/pull/53) - **Added DateTime::setTimeIn method** - [@norberttech](https://github.com/norberttech)

## [0.5.0] - 2020-08-24
### Added 
- [#52](https://github.com/aeon-php/calendar/pull/52) - **Add psalm-pure for static factory methods** - [@tomaszhanc](https://github.com/tomaszhanc)

## [0.4.0] - 2020-08-15
### Added
- [#51](https://github.com/aeon-php/calendar/pull/51) - **Added DateTime setTime and setDay methods** - [@norberttech](https://github.com/norberttech)
- [#49](https://github.com/aeon-php/calendar/pull/49) - **Updated phpunit to version ^9.3** - [@norberttech](https://github.com/norberttech)

## [0.3.0] - 2020-08-01
### Added
- [#48](https://github.com/aeon-php/calendar/pull/48) - **Moved tools to phive**  - [@norberttech](https://github.com/norberttech)
- [#46](https://github.com/aeon-php/calendar/pull/46) - **Optimize datetime static constructor**  - [@norberttech](https://github.com/norberttech)
- [#43](https://github.com/aeon-php/calendar/pull/43) - **Added more benchmarks** - [@norberttech](https://github.com/norberttech)
- [#45](https://github.com/aeon-php/calendar/pull/45) - **new static create  method for Day and Month classes** - [@eamirgh](https://github.com/eamirgh)
- [#40](https://github.com/aeon-php/calendar/pull/40) - **created timeBetween method for better experience issue** - [@eamirgh](https://github.com/eamirgh)

### Changed
- [#47](https://github.com/aeon-php/calendar/pull/47) - **Increased required infection MSI % to 100%** - [@norberttech](https://github.com/norberttech)
- [#44](https://github.com/aeon-php/calendar/pull/44) - **TimePeriod::overlaps performance improvements** - [@norberttech](https://github.com/norberttech)
- [#42](https://github.com/aeon-php/calendar/pull/42) - **Reduced complexity of toDateTimeImmutable conversion** - [@norberttech](https://github.com/norberttech)
- [#39](https://github.com/aeon-php/calendar/pull/39) - **Renamed equals to isEqual method fix issue** - [@eamirgh](https://github.com/eamirgh)

## [0.2.0] - 2020-07-16
### Added
- [#37](https://github.com/aeon-php/calendar/pull/37) - **Year/Month/Day manipulation and comparison methods** - [@norberttech](https://github.com/norberttech)
  - Year/Month/Day manipulation methods (plus/minus)
  - Year/Month/Day comparison methods (isAfter/isBefore...) 
   - Year/Month/Day iterate/since/until methods
  - `Years` - collection of years
  - `Days` - collection of days
  - `Months` - collection of months 
  
### Changed
- [#37](https://github.com/aeon-php/calendar/pull/37) - **Year/Month/Day manipulation and comparison methods** - [@norberttech](https://github.com/norberttech)
  - `Months` -> `YearMonths` 
  - `Days` -> `MonthDays` 
  
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
  - [#30](https://github.com/aeon-php/calendar/pull/30) - **Use bcmath to compare TimeUnits ** - [@norberttech](https://github.com/norberttech)
  - [#26](https://github.com/aeon-php/calendar/pull/26) - **Drop webmozart/assert dependnecy** - [@norberttech](https://github.com/norberttech)
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
  - [5cc1af](https://github.com/aeon-php/calendar/commit/5cc1af5093eb08aaebe7165abe9a61d67768ebcd) - **Don&#039;t enforce en as default locale** - [@norberttech](https://github.com/norberttech)
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

Generated by [Automation](https://github.com/aeon-php/automation)
