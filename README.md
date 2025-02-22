# 3littlebits/dummy

A simple library to generate dummy data for testing purposes.

## Requirements

- PHP >= 8.2
- ext-ctype
- fakerphp/faker ^1.23

## Installation

You can install the library via Composer:

```bash
composer require --dev 3littlebits/dummy
```

## Usage

You can use the functions provided by the library importing the Dummy class in your composer.json file:

```json
...
"autoload-dev": {
    "files": [
        "vendor/3littlebits/dummy/Dummy.php"
    ]
},
...
```

## License
This library is licensed under the MIT License. Please see the [LICENSE](LICENSE.md) file for details.


## Authors
- Cisco Delgado <fdelgados@gmail.com>