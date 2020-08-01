# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

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
### First release :tada:
- initial release
