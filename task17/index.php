<?php

use Entity\Article;
use Entity\User;

error_reporting(E_ALL);
ini_set('display_errors','On');
require "/var/www/html/sandbox/git/Homework/task17/vendor/autoload.php";

$mysql = new \config\MysqlConfig();

try {
    $mysql->connect();
} catch (Exception $e) {
    die("Mistake: {$e->getMessage()}\n");
}
$user = new User(20,'Alladin','Black','ab@example');
$userM= new \Service\UserManager($mysql);
$userM->save($user);
$article = new Article(100,"Article with user","This is test",$user);
$articleM = new \Service\ArticleManager($mysql);
$articleM->save($article);
print_r($articleM->getById(100));