# yii2-post
yii2 post module
[![StyleCI](https://styleci.io/repos/99547471/shield?branch=master)](https://styleci.io/repos/99547471)
[![Build Status](https://travis-ci.org/Graychen/yii2-post.svg?branch=master)](https://travis-ci.org/Graychen/yii2-post)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Graychen/yii2-post/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-post/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Graychen/yii2-post/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-post/?branch=master)

=============
Yii2 Database post

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
