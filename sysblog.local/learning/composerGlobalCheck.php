<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/4/18
 * Time: 2:29 PM
 */
//set_include_path(' ~/.composer/cache/files/');
require '/root/.composer/vendor/autoload.php'; // for global composer install this should be the require path
//require __DIR__ . '/vendor/autoload.php'; // For local this should be the require path.

$log = new Monolog\Logger('ComposerCheck');