# pMutex
A simple concurrent processes serializer using PHP [flock()](http://php.net/manual/en/function.flock.php).


## USAGE
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


## STRUCTURE
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


## COMPOSER
```json
"require": {
    "deryagin/pMutex": "master"
}
```
