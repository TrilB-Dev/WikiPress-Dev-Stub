# WikiPress Dev Stub

Development contracts and static-analysis dependencies for external WikiPress
integrations.

## Installation

Install the package as a development dependency:

```sh
composer require --dev trilbdev/wikipress-dev-stub
```

The package provides:

- WikiPress interfaces, helpers, and settings contracts in `wikipress-stubs.php`.
- WordPress declarations through `php-stubs/wordpress-stubs`.
- Elementor and Elementor Pro declarations through `arts/elementor-stubs`.

The WikiPress stubs are loaded by Composer's generated autoloader. They are
development declarations only and must not be loaded by a production plugin
bootstrap.

## PHPStan

Add the upstream stub files to the PHPStan bootstrap configuration when your
project does not already load them:

```neon
parameters:
	bootstrapFiles:
		- vendor/php-stubs/wordpress-stubs/wordpress-stubs.php
		- vendor/arts/elementor-stubs/elementor-stubs.php
		- vendor/autoload.php
```

## Development

```sh
composer validate
```
