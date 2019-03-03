<?php

require __DIR__.'/../vendor/autoload.php'; 

define('DOC_ROOT', __DIR__);
define('PAGE_DIR', DOC_ROOT . '/views');
define('ROUTES', DOC_ROOT . '/../app/config/routes.php');
define('USERS', DOC_ROOT . '/../app/config/users.php');

use App\Acl\Authenticate;
use App\Routing\Router;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();

$auth = new Authenticate($session);
$request = Request::createFromGlobals();
$psr7Factory = new DiactorosFactory();
$psrRequest = $psr7Factory->createRequest($request);

$router = new Router($psrRequest, DOC_ROOT, include ROUTES);

$execute = $router->match();
$params = $router->getRouteMatch()['match'];

?>
<html>
    <head>
        <link rel="stylesheet" href="/styles/main.css">
    </head>
    <body>
        <div class="container">
            <div class="header">Header</div>
            <div class="menu">
            	<a href="/home">Home</a>
            	<a href="/page/1">Page 1</a>
            	<a href="/page/2">Page 2</a>
            	<a href="/page/3">Page 3</a>
                <?php if ($auth->check()) {?>
                    <a href="/logout">Logout</a>
                <?php } else { ?>
                    <a href="/login">Login</a>
                <?php } ?>
                
            </div>
            <div class="content"><?php $execute($params, $auth, $request) ?></div>
            <div class="footer">Footer</div>
        </div>
    </body>
</html>