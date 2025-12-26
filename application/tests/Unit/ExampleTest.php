<?php

namespace App\Tests\Unit;

use App\Example;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Example
 */
class ExampleTest extends TestCase
{
    public function testAdd(): void
    {
        $example = new Example();
        $this->assertEquals(4, $example->add(2, 2));
        $this->assertEquals(0, $example->add(2, -2));
        $this->assertEquals(0, $example->sub(2, 2));
        $this->assertEquals(1, $example->sub(3, 2));
    }
}
