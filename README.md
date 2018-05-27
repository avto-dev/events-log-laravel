<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Логгирование событий в Laravel-приложениях

[![Version][badge_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![StyleCI][badge_styleci]][link_styleci]
[![Coverage][badge_coverage]][link_coverage]
[![Code Quality][badge_quality]][link_coverage]
[![Issues][badge_issues]][link_issues]
[![License][badge_license]][link_license]
[![Downloads count][badge_downloads_count]][link_packagist]

Данный пакет позволяет удобно использовать в вашем Laravel приложении функционал логгирования событий, которые реализуют определенный интерфейс.

## Установка

> Для использования данного пакета необходим Laravel версии 5.6 и выше.

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/events-log-laravel "^1.0"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета.

Сервис-провайдер будет зарегистрирован автоматически. В противном случае выполните:

```shell
$ php artisan package:discover
```

## Настройка

После установки пакета вам необходимо произвести его настройку. Минимальной конфигурацией является добавление в ваш файл `./config/logging.php` значения:

```php
<?php

return [
    // ...
    
    'events_channel' => env('EVENTS_LOG_CHANNEL', 'stack'),
    
    // ...
];
```

Где `stack` - это имя одного из каналов, перечисленного в секции `channels` этого же файла. Без указания данной опции логгирование будет производиться с использованием канала по умолчанию.

> Переопределить данную опцию вы сможете добавив в `.env` файл вашего приложения строку `EVENTS_LOG_CHANNEL=%channel_name%`.

Например, если вам необходимо производить логгирование событий в отдельный файл в формате `Monolog` и дополнительно вести запись в **другой файл** в формате `Logstash`, то конфигурация может иметь следующий вид:

```php
<?php

return [

    'events_channel' => env('EVENTS_LOG_CHANNEL', 'events-stack'),

    // ...    

    'channels' => [
    
        // ...

        'events-stack' => [
            'driver'   => 'stack',
            'channels' => ['events-monolog', 'events-logstash'],
        ],

        'events-monolog' => [
            'driver' => 'single',
            'path'   => storage_path('logs/laravel-events.log'),
            'level'  => 'debug',
        ],

        'events-logstash' => [
            'driver' => 'custom',
            'via'    => AvtoDev\EventsLogLaravel\Logging\EventsLogstashLogger::class,
            'path'   => storage_path('logs/logstash/laravel-events.log'),
            'level'  => 'debug',
        ],
    ],
];
```

Более подробно о настройке логгирования вы можете прочитать по [этой ссылке][laravel_logging].


## Использование

Данный пакет работает следующий образом:

- Сервис-провайдер данного пакета регистрирует свой "слушатель" на все события, что происходят в приложении;
- При получении события он проверяет реализацию класса события интерфейса `ShouldBeLoggedContract`;
- Если предыдущее условие выполняется - то используя указанный в файле `logging.php` канал логгирования производится запись данных которые возвращают методы, описанные в интерфейсе `ShouldBeLoggedContract`.

Пример класса логгируемого события:

```php
<?php

class SomeApplicationEvent implements \AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract
{
    /**
     * {@inheritdoc}
     */
    public function logLevel(): string
    {
        return 'info';
    }

    /**
     * {@inheritdoc}
     */
    public function logMessage(): string
    {
        return 'My log message';
    }

    /**
     * {@inheritdoc}
     */
    public function logEventExtraData(): array
    {
        return ['key' => 'any value'];
    }

    /**
     * {@inheritdoc}
     */
    public function eventType(): string
    {
        return 'default_event';
    }

    /**
     * {@inheritdoc}
     */
    public function eventSource(): string
    {
        return 'service_name';
    }
}
```

Теперь достаточно в произвольном месте вашего приложения вызвать:

```php
event(new SomeApplicationEvent);
```

И быть уверенным в том, что данное событие будет записано в лог-файл. О том, как работают события (events) в Laravel вы можете прочитать по [этой ссылке][laravel_events].

### Дополнительные логгеры

Вместе с данным пакетом вам доступны следующие пред-настроенные логгеры `AvtoDev\EventsLogLaravel\Logging\...`:

Класс логгера | Назначение
---------------- | ----------
`DefaultLogstashLogger` | Пишет лог-записи в формате `logstash`, не видоизменяя тело записи (поле `context` не изменяется)
`EventsLogstashLogger` | Пишет лог-записи в формате `logstash`, но данные связанные с событиями помещаются в секцию `event`

> Более подробно о них смотрите исходный код


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
[badge_styleci]:https://styleci.io/repos/134873016/shield
[badge_coverage]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/badges/coverage.png?b=master
[badge_quality]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/badges/quality-score.png?b=master
[badge_issues]:https://img.shields.io/github/issues/avto-dev/events-log-laravel.svg?style=flat&maxAge=30
[link_packagist]:https://packagist.org/packages/avto-dev/events-log-laravel
[link_styleci]:https://styleci.io/repos/134873016/
[link_license]:https://github.com/avto-dev/events-log-laravel/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/avto-dev/events-log-laravel/?branch=master
[link_issues]:https://github.com/avto-dev/events-log-laravel/issues
[laravel_logging]:https://laravel.com/docs/5.6/logging
[laravel_events]:https://laravel.com/docs/5.6/events
[getcomposer]:https://getcomposer.org/download/
