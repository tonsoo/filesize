<?php

namespace L1nnah\FileSize;

use InvalidArgumentException;

/**
 * ### A file size converter
 * 
 * #### What it can do:
 *  * Convert bytes to your desired unit;
 *  * Convert bytes to the closest unit;
 *  * Parse a unit text with the abbreviation (like 1 MB).
 * 
 * ### Usage
 * ```
 * <?php
 * // Create the converter
 * $converter = new FileSizeConverter(334567);
 * 
 * // Convert the size value to mb
 * $sizeInMb = $converter->convertTo(FileSizeUnits::MB);
 * print($sizeInMb->toFixed(2));
 * 
 * // Convert it to the closes readable
 * $sizeReadable = $converter->toClosestReadable();
 * print($sizeReadable->toFixed(2)); // For this example: 326.73 KB
 * ```
 */
class FileSizeConverter {
    public function __construct(
        public readonly float $sizeInBytes
    ) {
        if ($sizeInBytes < 0) {
            throw new InvalidArgumentException('Size must be greater or equal to zero (0).');
        }
    }

    /**
     * Convert to a specific size unit
     * @param \L1nnah\FileSize\FileSizeUnits $unit
     * @return FileSize
     */
    public function convertTo(FileSizeUnits $unit) : FileSize {
        $divisor = pow(1024, $unit->power());
        return new FileSize(
            $this->sizeInBytes / $divisor,
            $unit->unit()
        );
    }

    /**
     * Convert to the closest readable unit
     * @return FileSize
     */
    public function toClosestReadable() : FileSize {
        $bytes = $this->sizeInBytes;
        if ($bytes === 0.0) {
            return new FileSize(0.0, FileSizeUnits::B->unit());
        }

        $units = FileSizeUnits::cases();

        $power = floor(log($bytes) / log(1024));
        $unitIndex = (int) min($power, count($units) - 1);

        return new FileSize(
            $bytes / pow(1024, $unitIndex),
            $units[$unitIndex]->unit()
        );
    }

    /**
     * Create a new converter from a string text such as: 10 MB, 24 B, 2.34 TB
     * @param string $text
     * @throws \InvalidArgumentException
     * @return FileSizeConverter
     */
    public static function fromString(string $text) : self {
        $text = trim($text);

        if (!preg_match('/^([\d\.,]+)\s*([a-zA-Z]+)$/', $text, $matches)) {
            throw new InvalidArgumentException("Invalid format: '{$text}'");
        }

        $numberText = $matches[1];
        $unitText = strtoupper($matches[2]);

        $dotPos = strpos($numberText, '.');
        $commaPos = strpos($numberText, ',');

        $hasDot = $dotPos !== false;
        $hasComma = $commaPos !== false;

        $sizeStr = $numberText;
        if ($hasDot && $hasComma) {
            if ($commaPos > $dotPos) {
                $sizeStr = str_replace('.', '', $numberText);
                $sizeStr = str_replace(',', '.', $sizeStr);
            } else {
                $sizeStr = str_replace(',', '', $numberText);
            }
        } elseif ($hasComma) {
            $sizeStr = str_replace(',', '.', $numberText);
        }

        if (!is_numeric($sizeStr)) {
            throw new InvalidArgumentException("Invalid numeric value found: '{$numberText}'");
        }

        $size = (float) $sizeStr;

        $unitText = FileSizeUnits::tryFrom($unitText);

        if ($unitText === null) {
            throw new InvalidArgumentException("Unknown unit abbreviation: '{$unitText}'");
        }

        return new self($size * pow(1024, $unitText->power()));
    }
}
