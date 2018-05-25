<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Events logger for laravel applications

[![Version][badge_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![StyleCI][badge_styleci]][link_styleci]
[![Coverage][badge_coverage]][link_coverage]
[![Code Quality][badge_quality]][link_coverage]
[![Issues][badge_issues]][link_issues]
[![License][badge_license]][link_license]
[![Downloads count][badge_downloads_count]][link_packagist]

Данный пакет позволяет удобно использовать в вашем Laravel приложении функционал логгирования событий. 

## Установка

> Для использования данного пакета необходим Laravel версии 5.6 и выше.

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/events-log-laravel "^1.0"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета.

## Использование



### Тестирование

Для тестирования данного пакета используется фреймворк `phpunit`. Для запуска тестов выполните в терминале:

```shell
$ git clone git@github.com:avto-dev/events-log-laravel.git ./events-log-laravel && cd $_
$ composer install
$ composer test
$ composer phpstan
```

## Поддержка и развитие

Если у вас возникли какие-либо проблемы по работе с данным пакетом, пожалуйста, создайте соответствующий `issue` в данном репозитории.

Если вы способны самостоятельно реализовать тот функционал, что вам необходим - создайте PR с соответствующими изменениями. Крайне желательно сопровождать PR соответствующими тестами, фиксирующими работу ваших изменений. После проверки и принятия изменений будет опубликована новая минорная версия.

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].

[badge_version]:https://img.shields.io/packagist/v/avto-dev/events-log-laravel.svg?style=flat&maxAge=30
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/events-log-laravel.svg?style=flat&maxAge=30
[badge_license]:https://img.shields.io/packagist/l/avto-dev/events-log-laravel.svg?style=flat&maxAge=30
[badge_build_status]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/badges/build.png?b=master
[badge_styleci]:https://styleci.io/repos/none/shield
[badge_coverage]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/badges/coverage.png?b=master
[badge_quality]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/badges/quality-score.png?b=master
[badge_issues]:https://img.shields.io/github/issues/avto-dev/events-log-laravel.svg?style=flat&maxAge=30
[link_packagist]:https://packagist.org/packages/avto-dev/events-log-laravel
[link_styleci]:https://styleci.io/repos/none/
[link_license]:https://github.com/avto-dev/events-log-laravel/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/?branch=master
[link_issues]:https://github.com/avto-dev/events-log-laravel/issues
[getcomposer]:https://getcomposer.org/download/
