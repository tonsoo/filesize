<?php

namespace L1nnah\FileSize\Tests;

use InvalidArgumentException;
use L1nnah\FileSize\FileSizeConverter;
use L1nnah\FileSize\FileSizeUnits;
use PHPUnit\Framework\TestCase;

class FileSizeFromStringTest extends TestCase {
    public function testFromStringWithValidInputs() : void {
        $converter = FileSizeConverter::fromString('123.45 MB');
        $expectedBytes = 123.45 * (1024 ** FileSizeUnits::MB->power());
        $this->assertEquals($expectedBytes, $converter->sizeInBytes);

        $converter2 = FileSizeConverter::fromString('0 B');
        $this->assertEquals(0, $converter2->sizeInBytes);

        $converter3 = FileSizeConverter::fromString('512 KB');
        $expectedBytes3 = 512 * (1024 ** FileSizeUnits::KB->power());
        $this->assertEquals($expectedBytes3, $converter3->sizeInBytes);

        $converter4 = FileSizeConverter::fromString('1.5 GB');
        $expectedBytes4 = 1.5 * (1024 ** FileSizeUnits::GB->power());
        $this->assertEquals($expectedBytes4, $converter4->sizeInBytes);
    }

    public function testFromStringWithDecimalComma() : void {
        $converter = FileSizeConverter::fromString('123,45 MB');
        $expectedBytes = 123.45 * (1024 ** FileSizeUnits::MB->power());
        $this->assertEquals($expectedBytes, $converter->sizeInBytes);
    }

    public function testFromStringWithWhitespace() : void {
        $converter = FileSizeConverter::fromString("  78.9   GB  ");
        $expectedBytes = 78.9 * (1024 ** FileSizeUnits::GB->power());
        $this->assertEquals($expectedBytes, $converter->sizeInBytes);
    }

    public function testFromStringThrowsOnInvalidFormat() : void {
        $this->expectException(InvalidArgumentException::class);
        FileSizeConverter::fromString('nah');
    }

    public function testFromStringThrowsOnUnknownUnit() : void {
        $this->expectException(InvalidArgumentException::class);
        FileSizeConverter::fromString('123.45 XY');
    }

    public function testFromStringThrowsOnNonNumericSize() : void {
        $this->expectException(InvalidArgumentException::class);
        FileSizeConverter::fromString('abc MB');
    }
}
