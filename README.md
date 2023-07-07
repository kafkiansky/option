### Option that takes care of what you unwrap.

## Requirements

- PHP 8.1 or higher.

## Installation

The package could be installed with composer:

```shell
composer require kafkiansky/option
```

## Motivation

Every `Option` pattern implementation I've seen has allowed you to call `unwrap` and get either a value or an exception, which, in my opinion, is no different from calling methods from null.
Same behaviour. Same error on production. But what if static analysis would make you check for a value before getting it? No problem.

```php
<?php

declare(strict_types=1);

use Kafkiansky\Option\Option;

/**
 * @param Option<non-empty-string> $option
 */
function withName(Option $option): void
{
    echo $option->unwrap();
}
```

With this code you will get an `IfThisIsMismatch` error from psalm, because `unwrap` can only be called on type `Some<T>`, not `None`.

Let's fix that:

```php
<?php

declare(strict_types=1);

use Kafkiansky\Option\Option;

/**
 * @param Option<non-empty-string> $option
 */
function withName(Option $option): void
{
    if ($option->isSome()) {
        echo $option->unwrap();
    }
}
```

Everything is fine now.

This code is also error-prone with `NoValue` issue:

```php
<?php

declare(strict_types=1);

use Kafkiansky\Option\Option;

/**
 * @param Option<non-empty-string> $option
 */
function withName(Option $option): void
{
    if ($option->isNone()) {
        echo $option->unwrap();
    }
}
```

But this code has no errors because you have passed a default value for `None` type, so you can call `unwrap` without calling `isSome`.

```php
<?php

declare(strict_types=1);

use Kafkiansky\Option\Option;

/**
 * @param Option<non-empty-string> $option
 */
function withName(Option $option): void
{
    echo $option
        ->map(
            fn (string $name): string => 'User: '. $name,
            fn (): string => 'anonymous',
        )
        ->unwrap()
    ;
}
```

And this code also contains no errors:

```php
<?php

declare(strict_types=1);

use Kafkiansky\Option\Option;

/**
 * @param Option<non-empty-string> $option
 */
function withName(Option $option): void
{
    echo $option->unwrapOr('anonymous');
}
```

## Limitations

At the moment this package works best with Psalm, because PHPStan does not yet know how to understand the `if-this-is` annotation.

## Testing

``` bash
$ composer phpunit
```  

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.