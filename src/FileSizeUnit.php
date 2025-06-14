<?php

namespace L1nnah\FileSize;

/**
 * File size unit to be able to access the unit name and abbreviation
 */
class FileSizeUnit {
    public function __construct(
        public readonly string $name,
        public readonly string $abbr
    ) {}
}