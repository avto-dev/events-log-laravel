# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

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

### Fixes

- One more service provider fix

## v1.0.1

### Fixes

- Fix service provider binds error

## v1.0.0

### Changed

- First release

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
