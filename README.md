php 3fm now playing
==================================
This is a php library to retrieve and decode the now playing information from Dutch radio 3fm (NPO 3FM).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist golles/php-3fm-now-playing "*"
```

or add

```
"golles/php-3fm-now-playing": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code:

```php
$helper = new Helper3FM();
$helper->get3FMNowPlaying();
$nowPlaying = $helper->getResponse3FM();
echo ucwords($nowPlaying->artist . ' - ' . $nowPlaying->title);
```
