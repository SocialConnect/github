# <img src="https://socialconnect.github.io/assets/icons/mark-github.svg" width="27"> GitHub SDK
[![Build Status](https://travis-ci.org/SocialConnect/github.svg)](https://travis-ci.org/SocialConnect/github)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SocialConnect/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/common/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SocialConnect/common/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/common/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/socialconnect/github/v/stable.svg)](https://packagist.org/packages/socialconnect/github)
[![License](https://poser.pugx.org/SocialConnect/instagram/github.svg)](https://packagist.org/packages/socialconnect/github)

> Awesome SDK to work with [GitHub](https://developer.github.com/)

Available methods:

API | Methods | Documentation | Specification tests
--- | ------- | ------------- | -------------------

[Activity](https://developer.github.com/v3/activity/) | | [ ] | []
[Users](https://developer.github.com/v3/users/) |   | [ ] | [ ]
    | [getUser](https://developer.github.com/v3/users/#get-a-single-user) | [Х] | [Х]
    | [getSelf](https://developer.github.com/v3/users/#get-the-authenticated-user) | [ ] | [ ]
    | [updateUser](https://developer.github.com/v3/users/#update-the-authenticated-user) | [ ] | [ ]
    | [getUsers](https://developer.github.com/v3/users/#get-all-users) | [ ] | [ ]

## Authentication

This library is a Client only,

see OAuth provider in [socialconnect/auth](https://github.com/socialconnect/auth) project.

see Github WebHook Service in [ovr/github-webhook-service](https://github.com/ovr/github-webhook-service) project.

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
