<?php
namespace MBicknese\Tests\UID64;

use MBicknese\UID64\InvalidUid64Exception;
use MBicknese\UID64\InvalidUid64TextException;
use MBicknese\UID64\UID64;
use PHPUnit\Framework\TestCase;

/**
 * Class Uid64Test
 *
 * @package MBicknese\Tests\UID64
 * @author  Maarten Bicknese <maarten.bicknese@devmob.com>
 */
class Uid64Test extends TestCase
{
    public function testNew()
    {
        $id = Uid64::new();
        $this->assertInternalType('string', $id);
    }

    public function testIsUid64()
    {
        $this->assertTrue(Uid64::isUid64('9223372036854775807'), 'Max int value is a valid UID64');
        $this->assertTrue(Uid64::isUid64('0'), 'zero (0) is a valid UID64');
        $this->assertFalse(Uid64::isUid64('9223372036854775808'), 'One more than max int is not a valid UID64');
        $this->assertFalse(Uid64::isUid64('-1'), '-1 is not a valid UID64');
        $this->assertFalse(Uid64::isUid64('a'), 'a letter is not a valid UID64');
    }

    public function testToText()
    {
        $this->assertEquals('0', Uid64::toText('0'));
        $this->assertEquals('1y2p0ij32e8e7', Uid64::toText('9223372036854775807'));
        $this->assertEquals('7oxrx2x69ao', Uid64::toText('28125832510328208'));

        $this->expectException(InvalidUid64Exception::class);
        Uid64::toText('-1');
    }

    public function testFromText()
    {
        $this->assertEquals('0', Uid64::fromText('0'));
        $this->assertEquals('9223372036854775807', Uid64::fromText('1y2p0ij32e8e7'));
        $this->assertEquals('28125832510328208', Uid64::fromText('7oxrx2x69ao'));

        $this->expectException(InvalidUid64TextException::class);
        Uid64::fromText('!');
    }
}
