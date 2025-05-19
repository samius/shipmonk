<?php

namespace Samius;

use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{
    public function testInsertInt(): void
    {
        $list = new SortedLinkedList();
        $this->assertCount(0, $list);
        $list->insert(5);
        $this->assertCount(1, $list);
        $list->insert(3);
        $list->insert(3);
        $this->assertCount(3, $list);
        $list->insert(8);
        $this->assertCount(4, $list);

        $this->assertEquals([3, 3, 5, 8], $list->__toArray());
    }

    public function testInsertString(): void
    {
        $list = new SortedLinkedList();
        $this->assertCount(0, $list);
        $list->insert('c');
        $this->assertCount(1, $list);
        $list->insert('a');
        $this->assertCount(2, $list);
        $list->insert('d');
        $list->insert('d');
        $this->assertCount(4, $list);

        $this->assertEquals(['a', 'c', 'd', 'd'], $list->__toArray());
    }

    public function testRemove(): void
    {
        $list = new SortedLinkedList();
        $this->assertFalse($list->remove(5));
        $list->insert(5);
        $list->insert(3);
        $list->insert(8);
        $this->assertCount(3, $list);

        $this->assertTrue($list->remove(3));
        $this->assertCount(2, $list);
        $this->assertEquals([5, 8], $list->__toArray());

        $this->assertFalse($list->remove(10));
        $this->assertCount(2, $list);

        $list->insert(5);
        $this->assertEquals([5, 5, 8], $list->__toArray());
        $this->assertTrue($list->remove(5));
        $this->assertEquals([5, 8], $list->__toArray());
    }

    public function testEmptyToArray(): void
    {
        $list = new SortedLinkedList();
        $this->assertEquals([], $list->__toArray());
    }

    public function testTypeMismatch(): void
    {
        try {
            $list = new SortedLinkedList();
            $list->insert(5);
            $list->insert('a');
            $this->fail('Expected exception not thrown');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Expected type integer, got string', $e->getMessage());
        }

        try {
            $list = new SortedLinkedList();
            $list->insert('a');
            $list->insert(5);
            $this->fail('Expected exception not thrown');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Expected type string, got integer', $e->getMessage());
        }
    }

    public function testIsCompatibleType(): void
    {
        $listInt = new SortedLinkedList();
        $listString = new SortedLinkedList();

        $this->assertTrue($listInt->isCompatibleType(5));
        $this->assertTrue($listInt->isCompatibleType('a'));

        $this->assertTrue($listString->isCompatibleType(5));
        $this->assertTrue($listString->isCompatibleType('a'));

        $listString->insert('b');
        $this->assertFalse($listString->isCompatibleType(5));

        $listInt->insert(5);
        $this->assertFalse($listInt->isCompatibleType('a'));
    }

    public function testContains(): void
    {
        $listInt = new SortedLinkedList();
        $listString = new SortedLinkedList();
        $this->assertFalse($listInt->contains(5));
        $this->assertFalse($listString->contains('a'));

        $this->assertTrue($listInt->insert(5)->contains(5));
        $this->assertTrue($listString->insert('a')->contains('a'));

        $this->assertFalse($listInt->contains(10));
        $this->assertFalse($listInt->contains('b'));
        $this->assertFalse($listString->contains('b'));
        $this->assertFalse($listString->contains(10));

        $listInt->remove(5);
    }
}
