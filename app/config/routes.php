<?php
 
 use App\Routing\Router;

 return [
 	'home' => [
 		'uri' => '!^(/|/home)(/)?$!',
 		'exec' => function($matches, $auth, $request) {
 			include PAGE_DIR .'/home.php';
 		}
 	],

 	'login' => [
 		'uri' => '!^(/login)(/)?$!',
 		'exec' => function($matches, $auth, $request) {
 			$session = $auth->getSession();
 			include PAGE_DIR .'/login.php';
 		}
 	],

 	'login-user' => [
 		'uri' => '!^(/login-user)(/)?$!',
 		'exec' => function($matches, $auth, $request) {
 			if ($auth->loginUser($request, include USERS)) {
 				$response = new Symfony\Component\HttpFoundation\RedirectResponse('/page/1');
 				$response->send();
 			} else {
 				$session = $auth->getSession();
 				$session->set('login_error', 'Username or password is invalid');
 				$response = new Symfony\Component\HttpFoundation\RedirectResponse('/login');
 				$response->send();
 			}
 			
 		}
 	],

 	'logout' => [
 		'uri' => '!^(/logout)(/)?$!',
 		'exec' => function($matches, $auth, $request) {
 			$session = $auth->getSession();
 			$session->clear();
 			$response = new Symfony\Component\HttpFoundation\RedirectResponse('/login');
 			$response->send();
 		}
 	],

 	'page' => [
 		'uri' => '!^(/page)/(\d+)(/)?$!',
 		'exec' => function($matches, $auth, $request) {
 			if (! $auth->check()) {
 				$response = new Symfony\Component\HttpFoundation\RedirectResponse('/login');
 				$response->send();
 			} else {
 				$request = $auth->login($request);
 				include PAGE_DIR .'/page' . $matches[2] . '.php';
 			}
 			
 		}
 	],

 	Router::DEFAULT_MATCH => [
 		'uri' => '!.*!',
 		'exec' => function($matches, $auth, $request) {
 			include PAGE_DIR .'/404.php';
 		}
 	]
 ];