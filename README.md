# pMutex

**A simple concurrent processes serializer using PHP [flock()](http://php.net/manual/en/function.flock.php).**

[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Build Status](https://travis-ci.org/deryagin/pMutex.svg?branch=master)](https://travis-ci.org/deryagin/pMutex)


### Usage

Dafault case:
```php
    use pMutex\FlockProvider;
    use pMutex\ProcessSerializer;

    $lockId = 'ClassName::getAutoincrement()';
    $lockProvider = new FlockProvider($lockId);
    $processSerializer = new ProcessSerializer($lockProvider);
    $result = $processSerializer->runActoin(function() {
        // critical code
    });
```

Setup case:
```php
    use pMutex\FlockProvider;
    use pMutex\ProcessSerializer;

    $lockId = 'ClassName::getAutoincrement()';
    $lockProvider = new FlockProvider($lockId, '/var/tmp');

    $processSerializer = new ProcessSerializer($lockProvider);
    $processSerializer->setWaitSeconds(30)->setSleepMicrosec(10);
    $processSerializer->setFailCallback(function() {
        // return error of throw special exception
    });

    $result = $processSerializer->runActoin(function() {
        // critical code
        // return result
    });
```


### Structure

```sh
    pMutex
    ├── src
    │   ├── FlockProvider.php
    │   ├── ILockProvider.php
    │   ├── MutexException.php
    │   └── ProcessSerializer.php
    ├── composer.json
    ├── phpunit.xml
    ├── README.md
    └── LICENSE
```


### Composer

```json
    "require": {
        "deryagin/pMutex": "master"
    }
```
