<?php

declare(strict_types=1);

namespace Kafkiansky\Option;

/**
 * @template T
 * @template-extends Option<T>
 */
final class Some extends Option
{
    /**
     * @pure
     *
     * @param T $value
     */
    final protected function __construct(
        private readonly mixed $value,
    ) {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function unwrap(): mixed
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function unwrapOrElse(\Closure $default): mixed
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function andThen(\Closure $then): Option
    {
        return $this->map($then);
    }

    /**
     * {@inheritdoc}
     */
    public function or(Option $option): Option
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function map(\Closure $onSome, ?\Closure $onNone = null): Option
    {
        return self::some($onSome($this->value));
    }
}
