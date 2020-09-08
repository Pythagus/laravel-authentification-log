# Laravel Abstract Basis
Simple way to save in database your user authentifications.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Installation
You can quickly add this package in your application using Composer. **Be careful** to use the correct version of the package regarding your Laravel application version:

### Version
For now, this package supports **all Laravel versions from 5.5**.

### Composer
In a Bash terminal:
```bash
composer require pythagus/laravel-authentification-log
```

## Usage
In this section, we will see how to use the current package features.

##### Listener
The package works with Laravel listener for the ```Illuminate\Auth\Events\Login``` event. When this event is fired, 
the ```Pythagus\LaravelAuthentificationLog\Listeners\AuthentificationListener``` is caught and make a new instance of UserLogin.

You don't need to redeclare the listener to change the user data you want to store. The UserLogin model defines a treatment callable
that you can edit by publishing the model: 
```bash
php artisan vendor:publish --tag=auth-log-models
```

The method ```getDataFromUser()``` take the new logged in user as parameter. You can choose the stored data. For example, you can 
access the ip address like:
```php
public static function getDataFromUser(User $user) {
    return [
        'user_id' => $user->id,
        'ip_addr' => request()->ip(),
    ] ;
}
```

Don't forget the returned data array should be fillable. See ```UserLogin``` model.

##### Migration
This package includes a simple migration to generate the **user_login** table. You can publish the file executing:
```bash
php artisan vendor:publish --tag=auth-log-migrations
```

As well, you can edit your migration file regarding the fillable attribute of the ```UserLogin``` model.

##### Model UserLogin
The ```UserLogin``` model is used to manage the table instances. The ```created_at``` field is already casted as a datetime
to automatically return a Carbon instance. The ```authAt()``` method is only here to be more "logical" than "created_at".

If you want to custom the data, you also need to redeclare the ```UserLogin``` fillable attribute. You can publish the model executing:
```bash
php artisan vendor:publish --tag=auth-log-models
```

Don't forget to declare your own UserLogin in your ```AppServiceProvider``` register method:
```php
AuthentificationListener::setClass(UserLogin::class) ;
```

##### Model User
In your User model, you can use the ```AuthLoggable``` trait of this package to access useful methods.

## Architecture
This is the files' architecture of the package:

```
.
├── composer.json
├── LICENSE
├── README.md
└── src
    ├── AuthLogEventServiceProvider.php
    ├── AuthLogServiceProvider.php
    ├── Listeners
    │   └── AuthentificationListener.php
    ├── Migrations
    │   └── 2020_07_18_183731_create_user_login_table.php
    ├── Models
    │   └── UserLogin.php
    └── Traits
        └── AuthLoggable.php

5 directories, 9 files
```

You can generate the previous tree using:
```bash
sudo apt install tree
tree -I '.git|vendor'
```

## Licence
This package is under the terms of the [MIT license](https://opensource.org/licenses/MIT).
