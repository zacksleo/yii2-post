# yii2-post
yii2 post module
[![StyleCI](https://styleci.io/repos/99540308/shield?branch=master)](https://styleci.io/repos/99540308)
[![Build Status](https://travis-ci.org/monster-hunter/yii2-settings.svg?branch=master)](https://travis-ci.org/monster-hunter/yii2-settings)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/badges/build.png?b=master)](https://scrutinizer-ci.com/g/monster-hunter/yii2-settings/build-status/master)

Yii2 post
=============
Yii2 Database settings

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist zacksleo/yii2-post "*"
```

or add

```
"zacksleo/yii2-post": "*"
```

to the require section of your `composer.json` file.

Subsequently, run

```php
./yii migrate/up --migrationPath=@vendor/zacksleo/yii2-post/migrations
```

in order to create the settings table in your database.


```
