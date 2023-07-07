<?php

declare(strict_types=1);

namespace Kafkiansky\Option\Tests\unit;

use Kafkiansky\Option\NoneUnwrapped;
use Kafkiansky\Option\Option;
use PHPUnit\Framework\TestCase;

final class OptionTest extends TestCase
{
    public function testIsSome(): void
    {
        self::assertTrue(Option::some(2)->isSome());
    }

    public function testIsNone(): void
    {
        self::assertTrue(Option::none()->isNone());
        self::assertTrue(Option::some(null)->isNone());
    }

    public function testUnwrapSome(): void
    {
        self::assertSame(2, Option::some(2)->unwrap());
    }

    public function testUnwrapNone(): void
    {
        self::expectException(NoneUnwrapped::class);
        Option::none()->unwrap();
    }

    public function testUnwrapOr(): void
    {
        /** @psalm-var Option<int> $option */
        $option = Option::none();

        self::assertSame(2, $option->unwrapOr(2));

        /** @psalm-var Option<int> $option */
        $option = Option::some(3);

        self::assertSame(3, $option->unwrapOr(2));
    }

    public function testAndThen(): void
    {
        self::assertEquals(
            Option::some(4),
            Option::some(2)->andThen(fn (int $v): int => $v + 2),
        );

        self::assertEquals(
            Option::none(),
            /** @phpstan-ignore-next-line */
            Option::none()->andThen(fn (int $v): int => $v + 2),
        );
    }

    public function testUnwrapOrElse(): void
    {
        /** @psalm-var Option<int> $option */
        $option = Option::some(2);

        self::assertSame(2, $option->unwrapOrElse(fn (): int => 3));

        /** @psalm-var Option<int> $option */
        $option = Option::none();

        self::assertSame(3, $option->unwrapOrElse(fn (): int => 3));
    }

    public function testIsSomeAnd(): void
    {
        self::assertTrue(Option::some(2)->isSomeAnd(fn (int $v): bool => $v > 1));
        /** @phpstan-ignore-next-line */
        self::assertFalse(Option::none()->isSomeAnd(fn (int $v): bool => $v > 1));
    }

    public function testOr(): void
    {
        /** @psalm-var Option<int> $option */
        $option = Option::some(2);
        self::assertEquals(Option::some(2), $option->or(Option::some(3)));

        /** @psalm-var Option<int> $option */
        $option = Option::none();
        self::assertEquals(Option::some(3), $option->or(Option::some(3)));
    }
}
