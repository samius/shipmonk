<?php

namespace Samius;

use IteratorAggregate;
use Samius\SortedLinkedList\Item;

/**
 * @template T of int|string
 *
 * @implements IteratorAggregate<T>
 */
final class SortedLinkedList implements \IteratorAggregate, \Countable
{
    private ?string $type = null;

    /**
     * @var Item<T>|null
     */
    private ?Item $head = null;

    private int $count = 0;

    /**
     * @param T $value
     *
     * @return SortedLinkedList<T>
     */
    public function insert(string|int $value): self
    {
        $this->assertOrSetType($value);

        $newItem = $this->createItem($value);
        if (!$this->head) {
            $this->head = $newItem;
        } else {
            $current = $this->head;
            $previous = null;

            while (null !== $current && $current->compare($newItem) > 0) {
                $previous = $current;
                $current = $current->getNext();
            }
            if (null === $previous) {
                $newItem->setNext($this->head);
                $this->head = $newItem;
            } else {
                $previous->setNext($newItem);
                $newItem->setNext($current);
            }
        }
        $this->count++;

        return $this;
    }

    /**
     * @param T $value
     */
    public function remove(int|string $value): bool
    {
        $this->assertOrSetType($value);

        if (null === $this->head) {
            return false;
        }

        $current = $this->head;
        $previous = null;

        while (null !== $current && !$current->equalsValue($value)) {
            $previous = $current;
            $current = $current->getNext();
        }
        if (null === $current) {
            return false;
        }

        if (null === $previous) {
            $this->head = $current->getNext();
        } else {
            $previous->setNext($current->getNext());
        }

        $this->count--;

        return true;
    }

    /**
     * @param T $value
     */
    public function contains(int|string $value): bool
    {
        if (!$this->isCompatibleType($value)) {
            return false;
        }

        $current = $this->head;
        while (null !== $current) {
            if ($current->equalsValue($value)) {
                return true;
            }
            $current = $current->getNext();
        }

        return false;
    }

    public function isCompatibleType(string|int $value): bool
    {
        if (null === $this->type) {
            return true;
        }

        try {
            $this->assertOrSetType($value);

            return true;
        } catch (\InvalidArgumentException) {
            return false;
        }
    }

    /**
     * @return \Traversable<T>
     */
    public function getIterator(): \Traversable
    {
        $current = $this->head;
        while ($current) {
            yield $current->getValue();
            $current = $current->getNext();
        }
    }

    /**
     * @return list<T>
     */
    public function __toArray(): array
    {
        return iterator_to_array($this->getIterator(), true);
    }
    
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @param T $value
     *
     * @return Item<T>
     */
    private function createItem(int|string $value): Item
    {
        return new Item($value);
    }

    private function assertOrSetType(string|int $value): void
    {
        $currentType = gettype($value);

        if (null === $this->type) {
            $this->type = $currentType;
        }

        if ($currentType !== $this->type) {
            throw new \InvalidArgumentException(sprintf('Expected type %s, got %s', $this->type, $currentType));
        }
    }
}
