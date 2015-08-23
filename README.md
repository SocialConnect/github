# <img src="https://socialconnect.github.io/assets/icons/Instagram.png" width="27"> Instagram SDK
[![Build Status](https://scrutinizer-ci.com/g/SocialConnect/instagram/badges/build.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/instagram/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SocialConnect/instagram/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/instagram/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SocialConnect/instagram/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/instagram/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/socialconnect/instagram/v/stable.svg)](https://packagist.org/packages/socialconnect/instagram)
[![License](https://poser.pugx.org/SocialConnect/instagram/license.svg)](https://packagist.org/packages/socialconnect/instagram)

> Awesome SDK to work with [GitHub](https://developer.github.com/)

Available methods:

@todo

## Authentication

This library is a Client, see OAuth provider in [socialconnect/auth](https://github.com/socialconnect/auth) project.

## Installation

Add a requirement to your `composer.json`:

```json
{
    "require": {
        "socialconnect/github": "~0.1"
    }
}
```

Run the composer installer:

```bash
php composer.phar install
```

How to use
----------

First you need to create service:

```php
// Your GitHub Application's settings
$appId = 'appId';
$appSecret = 'secret';

$ghClient = new \SocialConnect\GitHub\Client($appId, $appSecret);
$ghClient->setHttpClient(new \SocialConnect\Common\Http\Client\Curl());
```

## Get user with specified $id:

```php
$ghClient = $ghClient->getUser('ovr');
var_dump($user);
```

## Customs methods

```php
$parameters = [];
$result = $ghClient->request('method/CustomMethod', $parameters);
if ($result) {
    var_dump($result);
}
```

## Custom entities

```php
class MyUserEntitiy extends \SocialConnect\GitHub\Entity\User {
    public function myOwnMethod()
    {
        //do something
    }
}

$ghClient->getEntityUser(new MyUserEntitiy());
$user = $ghClient->getUser(1);

if ($user) {
    $ghClient->myOwnMethod();
}
```

License
-------

This project is open-sourced software licensed under the MIT License. See the LICENSE file for more information.
