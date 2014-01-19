# Enum

## What is this?

This class is an attempt at making the closest approximation to enumerations from other programming languages as is possible in userland PHP code.

## Credits

The interface and overall design leans heavily on prior enumeration libraries, with [`SplEnum`](http://www.php.net/manual/en/class.splenum.php) and [`MyCLabs\Enum`](https://github.com/myclabs/php-enum) being the two largest influences.

## Raison d'être

None of the existing libraries that I have run across offer automatic value enumeration, which I felt was a pretty glaring omission.

## Requirements

The only requirement is PHP 5.4 or higher.

## Installation

## Declaration

Declaring an enumeration is done by extending the base class and providing your list of enumerators as `private static` properties:

```php
use drrcknlsn\Enum\Enum;

require 'vendor/autoload.php';

class DayOfWeek extends Enum
{
    private static
        $MONDAY = 1, // ISO-8601
        $TUESDAY,
        $WEDNESDAY,
        $THURSDAY,
        $FRIDAY,
        $SATURDAY,
        $SUNDAY;
}
```

## Usage

The enumerators are accessed by magic static methods:

```php
$day = DayOfWeek::WEDNESDAY(); // hump daaaay!
```

They can be typehinted like any other class:

```php
function isWeekend(DayOfWeek $day) {
    return $day === DayOfWeek::SATURDAY()
        || $day === DayOfWeek::SUNDAY();
}
```

You can also iterate an enumeration's values:

```php
foreach (DayOfWeek::getValues() as $day) {
    if ($day !== DayOfWeek::TUESDAY()) {
        continue;
    }
}
```
