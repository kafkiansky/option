<?php

declare(strict_types=1);

/**
 * @param \Kafkiansky\Option\Option<int> $option
 */
function takesOption(\Kafkiansky\Option\Option $option): void
{
    if ($option->isSome()) {
        echo $option->unwrap() + 1;
    }
}

/**
 * @param \Kafkiansky\Option\Option<int> $option
 */
function takesUncheckedOption(\Kafkiansky\Option\Option $option): void
{
    /** @psalm-suppress IfThisIsMismatch */
    echo $option->unwrap();
}

/**
 * @param \Kafkiansky\Option\Option<int> $option
 */
function unwrapNone(\Kafkiansky\Option\Option $option): void
{
    if ($option->isNone()) {
        /** @psalm-suppress NoValue */
        echo $option->unwrap();
    }
}

/**
 * @param \Kafkiansky\Option\Option<int> $option
 */
function unwrapMap(\Kafkiansky\Option\Option $option): void
{
    echo $option
            ->map(
                fn (int $code): string => (string) $code,
                fn (): int => 500
            )
            ->unwrap() > 200;
}

/**
 * @param \Kafkiansky\Option\Option<int> $option
 */
function unwrapMapWithoutDefault(\Kafkiansky\Option\Option $option): void
{
    /** @psalm-suppress IfThisIsMismatch */
    echo $option
            ->map(
                fn (int $code): string => (string) $code,
            )
            ->unwrap() > 200;
}
