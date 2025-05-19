<?php

namespace Samius\SortedLinkedList;

/**
 * @template T of int|string
 */
final class Item
{
    /**
     * @var T
     */
    private readonly string|int $value;

    /**
     * @var Item<T>|null
     */
    private ?Item $next = null;

    /**
     * @param T $value
     */
    public function __construct(int|string $value)
    {
        $this->value = $value;
    }

    public function getType(): string
    {
        return gettype($this->value);
    }

    /**
     * @return T
     */
    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * @return Item<T>|null
     */
    public function getNext(): ?Item
    {
        return $this->next;
    }

    /**
     * @param Item<T>|null $next
     *
     * @return Item<T>
     */
    public function setNext(?Item $next): self
    {
        $this->next = $next;

        return $this;
    }

    /**
     * @param Item<T> $item
     */
    public function compare(Item $item): int
    {
        $thisType = $this->getType();
        $itemType = $item->getType();
        if ($thisType !== $itemType) {
            throw new \InvalidArgumentException(sprintf('Cannot compare items of different types: %s and %s', $thisType, $itemType));
        }

        return $item->getValue() <=> $this->getValue(); // @phpstan-ignore shipmonk.comparingNonComparableTypes
    }

    /**
     * @param Item<T> $item
     */
    public function equals(Item $item): bool
    {
        return $this->getValue() === $item->getValue();
    }

    /**
     * @param T $value
     */
    public function equalsValue(int|string $value): bool
    {
        return $this->getValue() === $value;
    }
}
