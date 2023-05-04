# A package to connect milvus DB with php laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/developerssavyour/laravel-milvus.svg?style=flat-square)](https://packagist.org/packages/developerssavyour/laravel-milvus)
[![Total Downloads](https://img.shields.io/packagist/dt/developerssavyour/laravel-milvus.svg?style=flat-square)](https://packagist.org/packages/developerssavyour/laravel-milvus)
![GitHub Actions](https://github.com/developerssavyour/laravel-milvus/actions/workflows/main.yml/badge.svg)

This is the package to connect milvus Vector DB with laravel via its APIs

## Installation

You can install the package via composer:

```bash
composer require developerssavyour/milvus
```
Next, publish the configuration file:

```bash
php artisan vendor:publish --provider="DevelopersSavyour\Milvus\MilvusServiceProvider"
```
Or for Lumen Project manually add service provider: "DevelopersSavyour\Milvus\MilvusServiceProvider" to bootstrap/app.php and run

```bash
composer dump-autoload
```
## Usage

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email muhammad.hammad@savyour.com instead of using the issue tracker.

## Credits

-   [Hammad](https://github.com/developerssavyour)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
