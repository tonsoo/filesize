# 📦 FileSize — Human-friendly file size handling for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/l1nnah/filesize.svg)](https://packagist.org/packages/tonsoo/filesize)
[![Tests](https://img.shields.io/github/actions/workflow/status/l1nnah/filesize/run-tests.yml?branch=main)](https://github.com/tonsoo/filesize/actions)
[![License](https://img.shields.io/github/license/l1nnah/filesize.svg)](https://github.com/tonsoo/filesize/blob/main/LICENSE)

A lightweight and extensible PHP library to parse, format, and convert file sizes in a human-readable and localized way.


## 🚀 Features

- Convert bytes to human-readable formats (KB, MB, GB, etc.);
- Format file sizes with custom decimal and thousand separators;
- Parse strings like `"123.45 MB"` or `"1.234,56 KB"` into bytes;
- Multi-locale support with optional Laravel integration;
- Fully tested with PHPUnit.

## 📥 Installation

```bash
composer require l1nnah/filesize
```

## 🔧 Usage

Converting bytes to human-readable format:
```php
use L1nnah\FileSize\FileSizeConverter;
use L1nnah\FileSize\FileSizeUnits;

$valueInBytes = 123456;
$converter = new FileSizeConverter($valueInBytes);
$readable = $converter->convertTo(FileSizeUnits::KB);

echo $readable->toFixed(2); // Expected: "120.56 KB"
```
---
\
Parsing from human-readable string:
```php
use L1nnah\FileSize\FileSizeConverter;

$converter = FileSizeConverter::fromString("1.234,56 MB");
echo $converter->sizeInBytes; // Expected: "1294467072"
```

## ✅ Testing

PHPUnit was used for testing with the commands:
```bash
vendor/bin/phpunit tests/FileSizeTest.php
vendor/bin/phpunit tests/FileSizeFromStringTest.php
```

## 📫 Credits

Developed by **tonsoo** and published under the nickname of **l1nnah**.