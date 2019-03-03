<?php
 
namespace App\Acl;

class Authenticate
{
	const SESSION_KEY = 'auth';

	private $session;

	public function __construct($session) 
	{
		$this->session = $session;
	}

	public function getSession() 
	{
		return $this->session;
	}

	public function check() 
	{
		return !!$this->session->get('auth');
	}

	public function login($request) 
	{
		$auth = $this->session->get('auth');
		
		if (!$auth) {
			return $request;
		}

		$request->auth = $auth;
		return $request;
	}

	public function loginUser($request, $users) 
	{
		$username = $request->request->get('username');
		$password = $request->request->get('password');

		if (!$username || !$password) return false;

		$foundUser = [];

		foreach ($users as $user) {
			if ($user['username'] === $username) {
				$foundUser = $user;
				break;
			}
		}

		if (empty($foundUser)) return false;

		if ($foundUser['password'] !== $password) return false;

		$this->session->set('auth', ['name' => $foundUser['name']]);

		return true;
	}
}