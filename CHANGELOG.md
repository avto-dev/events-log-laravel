# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## Unreleased

### Added

- Laravel `11.x` support

### Changed

- Minimal Laravel version now is `10.0`
- Version of `composer` in docker container updated up to `2.7.4`
- Updated dev dependencies

## v3.4.1

### Fixed

- `CHANGELOG.md` updated with: Drop `Laravel: v9` support
- Minimal `Laravel` version `10.0`
- Build status shield

## v3.4.0

### Added

- Support Laravel `10.x`

### Changed

- Up minimal required `PHP` version to `8.1`
- Up minimal `psr/log` version `3.0`
- Up minimal `monolog/monolog` version `3.0`
- Up minimal `phpstan` version to `1.10`
- Up minimal `phpunit` version `10.0`
- Composer version up to `2.5.5`

## v3.3.0

### Added

- Support Laravel `9.x`

## v3.2.0

### Added

- Support PHP `8.x`

### Changed

- Minimal required PHP version now is `7.3`
- Composer `2.x` is supported now

## v3.1.0

### Changed

- Laravel `8.x` is supported now

## v3.0.0

### Changed

- Minimal required `illuminate/*` package versions now is `7.*`
- Minimal required PHP version now is `7.2.5`
- Minimal required `monolog/monolog` version now is `^2.0`
- `DefaultLogstashLogger`, `DefaultUdpLogstashLogger`, `EventsLogstashLogger` and `EventsUdpLogstashLogger` uses `'extra'` for extra keys (instead `false`) and `'context'` for context keys (instead `null`) inside logstash "fields" by default

### Added

- Method `skipLogging(): bool` in `ShouldBeLoggedContract` interface

## v2.2.0

### Changed

- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
- Minimal required PHP version now is `7.2`

### Added

- PHP 7.4 is supported now

## v2.1.0

### Changed

- Maximal `illuminate/*` packages version now is `6.*`

### Added

- GitHub actions for a tests running

## v2.0.0

### Added

- Docker-based environment for development
- Project `Makefile`

### Changed

- Maximal `Laravel` version now is `5.8.x`
- Dependency `laravel/framework` changed to `illuminate/*`
- Composer scripts
- `\AvtoDev\EventsLogLaravel\EventsLogServiceProvider` &rarr; `\AvtoDev\EventsLogLaravel\ServiceProvider`
- Method `subscribe` in `EventsSubscriberContract` now must returns `void`

### Removed

- Dev-dependency `avto-dev/dev-tools`

## v1.3.0

### Added

- Sending logstash logs using UDP protocol (`DefaultUdpLogstashLogger` and `EventsUdpLogstashLogger` loggers)

## v1.2.0

### Added

- `skipLogging` method can be used in events, that implement `ShouldBeLoggedContract` interface (if method calling returns `true` - logging will be skipped) [#1]

[#1]:https://github.com/avto-dev/events-log-laravel/issues/1

### Changed

- `phpstan` minimal version now is `0.10.2`

## v1.1.0

### Changed

- Maximal PHP version now is undefined
- Maximal `laravel/framework` version now is `5.7.*`
- CI changed to [Travis CI][travis]
- [CodeCov][codecov] integrated
- Issue templates updated

[travis]:https://travis-ci.org/
[codecov]:https://codecov.io/

## v1.0.3

### Changed

- Package `avto-dev/dev-tools` updated up to `1.1.6`
- Minimal package `monolog/monolog` version now is `1.20`
- Removed unimportant phpdocs

## v1.0.2

### Fixed

- One more service provider fix

## v1.0.1

### Fixed

- Fix service provider binds error

## v1.0.0

### Changed

- First release

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
