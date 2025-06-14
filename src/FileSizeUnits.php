<?php

namespace L1nnah\FileSize;

/**
 * All file size units
 */
enum FileSizeUnits : string {
    case B = 'B';
    case KB = 'KB';
    case MB = 'MB';
    case GB = 'GB';
    case TB = 'TB';
    case PB = 'PB';
    case EB = 'EB';
    case ZB = 'ZB';
    case YB = 'YB';

    /**
     * Get the unit from a file size unit enum value
     * @return FileSizeUnit
     */
    public function unit() : FileSizeUnit {
        return new FileSizeUnit(
            self::translatedName(),
            FileSizeTranslatable::translate($this->value)
        );
    }

    /**
     * Translate the unit name
     * @return string
     */
    private function translatedName() : string {
        return match ($this) {
            self::B  => FileSizeTranslatable::translate('Bytes'),
            self::KB => FileSizeTranslatable::translate('Kilobyte'),
            self::MB => FileSizeTranslatable::translate('Megabyte'),
            self::GB => FileSizeTranslatable::translate('Gigabyte'),
            self::TB => FileSizeTranslatable::translate('Terabyte'),
            self::PB => FileSizeTranslatable::translate('Petabyte'),
            self::EB => FileSizeTranslatable::translate('Exabyte'),
            self::ZB => FileSizeTranslatable::translate('Zettabyte'),
            self::YB => FileSizeTranslatable::translate('Yottabyte'),
        };
    }

    /**
     * Get the power value related to a file size
     * @return int
     */
    public function power() : int {
        return match ($this) {
            FileSizeUnits::B => 0,
            FileSizeUnits::KB => 1,
            FileSizeUnits::MB => 2,
            FileSizeUnits::GB => 3,
            FileSizeUnits::TB => 4,
            FileSizeUnits::PB => 5,
            FileSizeUnits::EB => 6,
            FileSizeUnits::ZB => 7,
            FileSizeUnits::YB => 8,
        };
    }
}
