<?php
/**
 * @license   https://github.com/Init/licese.md
 * @copyright Copyright (c) 2017
 * @author    : bugbear
 * @date      : 2017/3/16
 * @time      : 下午1:16
 */
define('APP_ROOT', dirname(dirname(__FILE__)));
require APP_ROOT . '/vendor/autoload.php';
$config = require APP_ROOT . '/api/config/index.php';

use Courser\Courser;
use Courser\Session\Session;
use Courser\Server\HttpServer;
use Knight\Middleware\Cors;
use Knight\Middleware\Auth;
use Courser\Helper\Config;

Config::set($config);
$app = new Courser('dev');
$cors = new Cors();
$session = new Session($config['session']);
$app->used($session);
$app->any('*', $cors);
$app->notFound(function($req, $res) {
    $res->status(404)->json(['message' => 'Not Found']);
});

$app->get('/test', function($req, $res) {
   $res->send('fuck world');
});

$app->get('/', ['\Knight\Controller\Article' => 'posts']);

$app->get('/posts/:id', ['\Knight\Controller\Article' => 'detail']);
$app->get('/comments/:id', ['\Knight\Controller\Article' => 'comments']);
$app->post('/register', ['\Knight\Controller\Auth' => 'register']);
$app->post('/login', ['\Knight\Controller\Auth' => 'login']);

$app->get('/admin/article', ['\Knight\Controller\Admin' => 'article']);

//$app->group('/admin', function() {
//    $auth = new Auth(Config::get('jwt'), 'knight');
//    $this->used($auth);
//    $this->get('/article', ['\knight\Controller\Admin']);
//});




$server = new HttpServer($app);
$server->start();