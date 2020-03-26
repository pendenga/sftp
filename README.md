# Pendenga Sftp Library

![1 Test](https://img.shields.io/badge/tests-1-blue.svg)
![2 Assertions](https://img.shields.io/badge/assertions-2-blue.svg)
![100% Coverage](https://img.shields.io/badge/coverage-100%25-green.svg)

This is the package implementation for pushing to Domo's SFTP connector. 
It handles all the package includes and negotiateing with Vault to get the security certificate (pem).    

## Installation

This package is hosted on Packagist and is installable via [Composer][link-composer].

### Requirements

- PHP version 7.1 or greater
- Composer (for installation)

### Installing Via Composer

Run the following command (assuming `composer` is available in your PATH):

```bash
$ composer require pendenga/domo
```

## Usage

After creating a Domo data set, you'll get a `dataset_id` which is used as the remote filename. That ID is a dependency
as you initialize the object. 
 
```php
// using example iniLoader to simplify
$ini = new IniLoader();
$domo = new DomoPush($ini, new EchoLogger());
$domo->push($local_file, $domo->getRemoteFilename($ini->domoDatasetId()));
``` 
  
[link-composer]: https://getcomposer.org/
