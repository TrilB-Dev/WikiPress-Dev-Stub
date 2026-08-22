# WikiPress Dev Stub

Development contracts and static-analysis dependencies for external WikiPress
integrations.

## Installation

Install the package as a development dependency:

```sh
composer require --dev trilbdev/wikipress-dev-stub
```

PHPStans projects only
```sh
composer require --dev szepeviktor/phpstan-wordpress
```

The package provides:

- WikiPress interfaces, helpers, and settings contracts in `wikipress-stubs.php`.
- WordPress declarations through `php-stubs/wordpress-stubs`.

The WikiPress stubs are loaded by Composer's generated autoloader. They are
development declarations only and must not be loaded by a production plugin
bootstrap.

## PHPStan

Install `szepeviktor/phpstan-wordpress` in the consuming project to enable
WordPress-specific PHPStan rules. Then add its extension and the required
declaration files to the project's `phpstan.neon`:

```neon
includes:
	- vendor/szepeviktor/phpstan-wordpress/extension.neon

parameters:
	bootstrapFiles:
		- vendor/php-stubs/wordpress-stubs/wordpress-stubs.php
		- vendor/autoload.php
```

No separate PHPStan bootstrap PHP file is required for this package. Composer
loads `wikipress-stubs.php` through the package autoload configuration. The
`includes` and `bootstrapFiles` entries belong in the consuming project's
`phpstan.neon` (or equivalent configuration), not in this package. Projects
using PHPStan's extension installer may not need to add the `includes` entry
manually.

## Development

```sh
composer validate
```
