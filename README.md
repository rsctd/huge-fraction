# huge-fraction
A PHP library to work with huge fractions

### Prerequisites
 - PHP version >= 7.0.0

### Installation
In your project folder:

```shell
composer require rsctd/huge-fraction
```

### Usage
```php
require_once __DIR__.'/../vendor/autoload.php';

use Rsctd\HugeFraction\Fraction;

$fraction = Fraction::fromString('3 2/5');
var_dump($fraction);
```

### Running tests
To run the tests locally, run the command
```
composer test
```

### Reference
Thanks for https://github.com/phospr/fraction
