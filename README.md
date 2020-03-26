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

After creating a Domo data set, you'll get a `dataset_id` which is used for the remote filename. That's the only 
loose variable. All the reset of the connection information can be abstracted in a SftpLoaderInterface, in this case
the demo class IniLoader.
 
```php
// using example iniLoader to simplify (1 variable to look up)
$domo = new DomoPush(new IniLoader());
$domo->push($local_file, $domo->getRemoteFilename($domo_dataset_id));


// manual sftp operation (5 variables to look up)
$sftp = new SFTP($sftp_remote_path);
$rsa = new RSA();
$rsa->setPassword($rsa_password);
$rsa->loadKey(base64_decode($rsa_key_base64));
$sftp->login($sftp_username, $rsa);
$sftp->put($remote_file, $local_file, SFTP::SOURCE_LOCAL_FILE);
``` 
  
[link-composer]: https://getcomposer.org/
