<?php

namespace L1nnah\FileSize\Tests;

use InvalidArgumentException;
use L1nnah\FileSize\FileSize;
use L1nnah\FileSize\FileSizeConverter;
use L1nnah\FileSize\FileSizeUnits;
use PHPUnit\Framework\TestCase;

class FileSizeTest extends TestCase {
    public function testReadableFormat() : void {
        $fileSizeConverter = new FileSizeConverter(123456);
        $fileSize = $fileSizeConverter->convertTo(FileSizeUnits::KB);

        $this->assertEquals('120.56 KB', $fileSize->toFixed(2));
    }

    public function testZeroBytes() : void {
        $fileSize = new FileSize(0, FileSizeUnits::B->unit());
        $this->assertEquals('0 B', (string)$fileSize);
    }

    public function testBytesUnderOneKB() : void {
        $fileSize = new FileSize(512, FileSizeUnits::B->unit());
        $this->assertEquals('512 B', (string)$fileSize);
    }

    public function testConvertToMB() : void {
        $fileSizeConverter = new FileSizeConverter(1048576);
        $fileSize = $fileSizeConverter->convertTo(FileSizeUnits::MB);
        $this->assertEquals('1.00 MB', $fileSize->toFixed(2));
    }

    public function testConvertToGB() : void {
        $fileSizeConverter = new FileSizeConverter(1073741824);
        $fileSize = $fileSizeConverter->convertTo(FileSizeUnits::GB);
        $this->assertEquals('1.00 GB', $fileSize->toFixed(2));
    }

    public function testToClosestReadableSmallFile() : void {
        $fileSizeConverter = new FileSizeConverter(500);
        $fileSize = $fileSizeConverter->toClosestReadable();
        $this->assertEquals('500 B', (string)$fileSize);
    }

    public function testToClosestReadableLargeFile() : void {
        $fileSizeConverter = new FileSizeConverter(15728640);
        $fileSize = $fileSizeConverter->toClosestReadable();
        $this->assertEquals('15.00 MB', $fileSize->toFixed(2));
    }

    public function testToClosestReadableVeryLargeFile() : void {
        $fileSizeConverter = new FileSizeConverter(1099511627776);
        $fileSize = $fileSizeConverter->toClosestReadable();
        $this->assertEquals('1.00 TB', $fileSize->toFixed(2));
    }

    public function testNegativeSizeThrows() : void {
        $this->expectException(InvalidArgumentException::class);
        new FileSizeConverter(-100);
    }

    public function testZeroSizeToClosestReadable() : void {
        $fileSizeConverter = new FileSizeConverter(0);
        $fileSize = $fileSizeConverter->toClosestReadable();
        $this->assertEquals('0 B', (string)$fileSize);
    }
}
