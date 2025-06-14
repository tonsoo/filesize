<?php

namespace L1nnah\FileSize;

/**
 * Represents a file size, such as 1 MB, 24 GB, 99 B, etc.
 */
class FileSize {
    public function __construct(
        public readonly float $size,
        public readonly FileSizeUnit $unit,
    ) {}

    public function __tostring() : string {
        return $this->size . ' ' . $this->unit->abbr;
    }

    /**
     * Format your file size to the amount of decimal cases necessary
     * @param int $decimalCases
     * @return string
     */
    public function toFixed(int $decimalCases) : string {
        $decimalSep = FileSizeTranslatable::translate('filesize.decimal-separator');
        $thousandsSep = FileSizeTranslatable::translate('filesize.thousands-separator');
        return number_format($this->size, $decimalCases, $decimalSep, $thousandsSep) . ' ' . $this->unit->abbr;
    }
}