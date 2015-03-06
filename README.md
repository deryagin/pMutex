# pMutex

**A simple concurrent processes serializer using PHP [flock()](http://php.net/manual/en/function.flock.php).**

[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Build Status](https://travis-ci.org/deryagin/pMutex.svg?branch=master)](https://travis-ci.org/deryagin/pMutex)


### Caution
> **Warning** On some operating systems **flock()** is implemented at the process level.
> When using a multithreaded server API like ISAPI you may not be able to rely on **flock()**
> to protect files against other PHP scripts running in parallel threads of the same server instance!

There is another problem with NFS. See this [comment](http://php.net/manual/en/function.flock.php#82521).
Also **flock()** uses a local server resource -- the file system. This may be a problem when you will need to resolve
a scaling problem. That's why this project containts `src/ILockProvider.php` interface. Use it for a type hinting
instead of `src/FlockProvider.php`


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
