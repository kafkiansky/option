<?php

declare(strict_types=1);

namespace Kafkiansky\Option;

/**
 * @template T
 * @template-extends Option<T>
 */
final class None extends Option
{
    /**
     * @pure
     */
    final protected function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function unwrap(): never
    {
        throw new NoneUnwrapped();
    }

    /**
     * {@inheritdoc}
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function unwrapOrElse(\Closure $default): mixed
    {
        return $default();
    }

    /**
     * {@inheritdoc}
     */
    public function andThen(\Closure $then): Option
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public function or(Option $option): Option
    {
        return $option;
    }

    /**
     * {@inheritdoc}
     */
    public function map(\Closure $onSome, ?\Closure $onNone = null): Option
    {
        return null !== $onNone ? self::some($onNone()) : self::none();
    }
}
