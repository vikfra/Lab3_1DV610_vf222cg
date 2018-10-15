<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $manager;


	public function __construct($manager) {
		$this->manager = $manager;
	}
	
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = $this->manager->message;

		if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && $this->userHasLogOut() == false) {
			if (!isset($_SESSION['refreshed'])) {
				$response = $this->generateLogoutButtonHTML($message);
			} else {
				$message = '';
				$response = $this->generateLogoutButtonHTML($message);
			}
			$_SESSION['refreshed'] = true;
		} else if ($this->userHasLogOut() == true) {

			if (!isset($_SESSION['logoutRefresh'])) {
				$response = $this->generateLoginFormHTML($message);
			} else {
				$message = '';
				$response = $this->generateLoginFormHTML($message);
			}
			$_SESSION['logoutRefresh'] = true;
		} else {
			$response = $this->generateLoginFormHTML($message);
		}
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getCookie() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		if(isset($_POST[self::$name])) {
			return $_POST[self::$name];
		} else {
			return false;
		}
	}


	public function getRequestPassWord () {
		if(isset($_POST[self::$password])) {
			return $_POST[self::$password];
		} else {
			return false;
		}
	}

	public function userHasLogIn () {
		return isset($_POST[self::$login]);
	}

	public function userHasLogOut () {
		return isset($_POST[self::$logout]);
	}

	public function getCookie() {
		if(isset($_COOKIE['username'])) {
			return $_COOKIE['username'];
		} else {
			return "Admin";
		}
	}

	public function userWillBeRemembered () {
		return isset($_POST[self::$keep]);
	}

	public function getButton () {
		return "<a href='?register'>Register a new user</a>";
	}
}