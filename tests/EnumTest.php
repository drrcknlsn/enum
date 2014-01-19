<?php
use Drrcknlsn\Enum\Enum;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConstantReturnsInstance()
    {
        $this->assertInstanceOf('Foo', Foo::A());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testInvalidConstantThrowsException()
    {
        Foo::DOES_NOT_EXIST();
    }

    public function testSameConstantReturnsSameInstance()
    {
        $this->assertSame(Foo::A(), Foo::A());
    }

    public function testConstantComparisonsCompareValues()
    {
        $this->assertTrue(Foo::B() > Foo::A());
        $this->assertTrue(Foo::D() < Foo::E());
        $this->assertTrue(Foo::C() > Foo::A());
        $this->assertTrue(Foo::C() < Foo::E());
    }

    public function testDefaultValuesAreGenerated()
    {
        $this->assertSame(0, Foo::A()->getValue());
        $this->assertSame(1, Foo::B()->getValue());
    }

    public function testExplicitValuesAreKept()
    {
        $this->assertSame(23, Foo::C()->getValue());
    }

    public function testExplicitValuesCauseSkippedGeneratedValues()
    {
        $this->assertSame(24, Foo::D()->getValue());
        $this->assertSame(25, Foo::E()->getValue());
    }

    public function testGetValuesReturnsEnumeratorList()
    {
        $this->assertSame([
            'A' => 0,
            'B' => 1,
            'C' => 23,
            'D' => 24,
            'E' => 25,
            'F' => 'test'
        ], Foo::getValues());
    }
}

class Foo extends Enum
{
    private static
        $A,
        $B,
        $C = 23,
        $D,
        $E,
        $F = 'test';
}
