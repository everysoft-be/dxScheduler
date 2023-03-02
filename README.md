[<img src="https://www.everysoft.be/logo_full.jpg">](https://www.everysoft.be)
# everysoft/scheduler
[![Latest Version on Packagist](https://img.shields.io/packagist/v/everysoft/scheduler.svg?style=flat-square)](https://packagist.org/packages/everysoft/scheduler)
[![Total Downloads](https://img.shields.io/packagist/dt/everysoft/scheduler.svg?style=flat-square)](https://packagist.org/packages/everysoft/scheduler)

A [laravel](https://laravel.com/) package to manage [scheduler](https://js.devexpress.com/Demos/WidgetsGallery/Demo/Scheduler/Overview/jQuery/Light/) using [jQuery DevExtreme library](https://js.devexpress.com/)

## Documentation

See the [documentation wiki](https://github.com/everysoft-be/scheduler/wiki) for detailed installation and usage instructions.

### Installation
```bash
# composer install everysoft/scheduler
```

### Usage exemple
* Show customer calendar
```php
<livewire:everysoft-scheduler></livewire:everysoft-scheduler>
```
* Show specific calendars
```php
<livewire:everysoft-scheduler 
        :references="['first', 'seconde', 'group/'.$group->id]"
    ></livewire:everysoft-scheduler>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

You can [contact](https://www.everysoft.be/contactez-nous/) us for more information.

## Security, issues

If you discover any security-related issues, please email [support@everysoft.be](mailto:support@everysoft.be) instead of using the issue tracker.
If you have any question or you found a bug, please send it to [GitHub Issues board](https://github.com/everysoft-be/scheduler/issues).
