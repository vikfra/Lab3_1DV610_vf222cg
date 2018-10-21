<?php
namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $register = 'register';
	private $manager;


	public function __construct($manager) {
		$this->manager = $manager;
	}
	
	public function response(): string {
		$message = $this->manager->message;
		$isLoggedIn = $this->manager->isLoggedIn();

		if ($isLoggedIn && $this->userHasLogOut() == false) {
			$isRefreshed = $this->manager->isSessionRefreshed();

			if (!$isRefreshed) {
				$response = $this->generateLogoutButtonHTML($message);

			} else {
				$message = '';
				$response = $this->generateLogoutButtonHTML($message);

			}

			$this->manager->setSessionRefreshed(true);

		} else if ($this->userHasLogOut() == true) {
			$isLogoutRefresh = $this->manager->isSessionLogoutRefreshed();

			if (!$isLogoutRefresh) {
				$response = $this->generateLoginFormHTML($message);

			} else {
				$message = '';
				$response = $this->generateLoginFormHTML($message);

			}

			$this->manager->setSessionLogoutRefreshed(true);

		} else {
			$response = $this->generateLoginFormHTML($message);

		}

		return $response;
	}

	private function generateLogoutButtonHTML($message): string {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML($message): string {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getUsernameCookie() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	

	public function getRequestUserName() {
		if(isset($_POST[self::$name])) {
			return $_POST[self::$name];
		} else {
			return false;
		}
	}

	public function getRequestPassWord() {
		if(isset($_POST[self::$password])) {
			return $_POST[self::$password];
		} else {
			return false;
		}
	}

	public function userHasLogIn(): bool {
		return isset($_POST[self::$login]);
	}

	public function userHasLogOut(): bool {
		return isset($_POST[self::$logout]);
	}

	public function getUsernameCookie(): string {
		if(isset($_COOKIE['username'])) {
			return $_COOKIE['username'];
		} else {
			return "Admin";
		}
	}

	public function getPasswordCookie() {
		if(isset($_COOKIE['password'])) {
			return $_COOKIE['password'];
		} else {
			return false;
		}
	}

	public function hasUsernameCookie(): bool {
		if(isset($_COOKIE['username'])) {
			return true;
		} else {
			return false;
		}
	}

	public function hasPasswordCookie(): bool {
		if(isset($_COOKIE['password'])) {
			return true;
		} else {
			return false;
		}
	}

	public function unsetCookie(): void {
		unset($_COOKIE['username']);
		unset($_COOKIE['password']);

		setcookie ('username', '', time() - (86400 * 30));
		setcookie ('password', '', time() - (86400 * 30));
	}

	public function userWillBeRemembered(): bool {
		return isset($_POST[self::$keep]);
	}

	public function getButton(): string {
		return "<a href='?" . self::$register . "'>Register a new user</a>";
	}
}