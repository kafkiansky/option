<?php

declare(strict_types=1);

namespace Kafkiansky\Option;

/**
 * @template T
 */
abstract class Option
{
    /**
     * @pure
     * @template E
     *
     * @param E $value
     *
     * @psalm-return (E is null ? None<E> : Some<E>)
     * @phpstan-return (E is null ? None<E> : Some<E>)
     */
    final public static function some(mixed $value): Option
    {
        return null !== $value ? new Some($value) : new None();
    }

    /**
     * @pure
     * @template E
     *
     * @return None<E>
     */
    final public static function none(): None
    {
        return new None();
    }

    /**
     * @psalm-this-out Some<T>
     * @phpstan-this-out Some<T>
     */
    final public function isSome(): bool
    {
        return $this instanceof Some;
    }

    /**
     * @psalm-this-out None<T>
     * @phpstan-this-out None<T>
     */
    final public function isNone(): bool
    {
        return $this instanceof None;
    }

    /**
     * @param \Closure(T): bool $f
     */
    final public function isSomeAnd(\Closure $f): bool
    {
        return $this->isSome() ? $f($this->unwrap()) : false;
    }

    /**
     * @psalm-if-this-is Some<T>
     * @return T
     */
    abstract public function unwrap(): mixed;

    /**
     * @param T $default
     *
     * @return T
     */
    abstract public function unwrapOr(mixed $default): mixed;

    /**
     * @param \Closure(): T $default
     *
     * @return T
     */
    abstract public function unwrapOrElse(\Closure $default): mixed;

    /**
     * @template E
     * @param \Closure(T): E $then
     *
     * @return Option<E>
     */
    abstract public function andThen(\Closure $then): Option;

    /**
     * @param Option<T> $option
     *
     * @return Option<T>
     */
    abstract public function or(Option $option): Option;

    /**
     * @template Te
     * @psalm-param \Closure(T): Te       $onSome
     * @psalm-param (\Closure(): Te)|null $onNone
     *
     * @psalm-return ($onNone is null ? Option<Te> : Some<Te>)
     * @phpstan-return ($onNone is null ? Option<Te> : Some<Te>)
     */
    abstract public function map(\Closure $onSome, ?\Closure $onNone = null): Option;
}
