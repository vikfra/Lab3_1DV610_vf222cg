<?php
    namespace model;

    require_once('model/DBconnection.php');

    class LogInManager {
        public $message;
        private static $login = 'LogInManager::loggedIn';
        private static $name = 'LogInManager::username';
        private static $browser = 'LogInManager::browser';
        private static $refreshed = 'LogInManager::refreshed';
        private static $httpUserAgent = 'HTTP_USER_AGENT';


        public function authenticateLogIn(string $username, string $password, bool $willBeRemembered, bool $authWithCookie): void {
            if (!$this->validCredentials($username, $password)) {
                return;

            }

            $isLoggedIn = $this->isAuthenticated($username, $password, $authWithCookie);

            if ($isLoggedIn) {
                $this->setSessionUsername($username);
                $this->setSessionLogIn($isLoggedIn);
                $this->setWelcomeMsg($authWithCookie, $willBeRemembered);

            } else {
                $this->setErrorMsg($authWithCookie, $willBeRemembered);
                $this->setSessionLogIn($isLoggedIn);
                $this->unsetCookies();
            }
        }

        public function isLoggedIn (): bool {
            if (isset($_SESSION[self::$login]) && $_SESSION[self::$login] == true) {
                return true;
            } else {
                return false;
            }
        }

        public function validCredentials (string $username, string $password): bool {
            if (empty($username)) {
                $this->message = 'Username is missing';
                return false;
            } else if (empty($password)) {
                $this->message = 'Password is missing';
                return false;
            } else {
                return true;
            }
        }

        public function isAuthenticated(string $username, string $password, bool $authWithCookie): bool {
            if (!$authWithCookie) {
                $password = $this->hashPassword($password);
            }
            if ($this->hasAuthUser($username, $password) || $this->hasAuthAdmin($username, $password)) {
                return true;
            } else {
                return false;
            }
        }

        public function hasAuthUser (string $username, string $password): bool {
            if($this->isSessionHijacked()) {
                return false;
            }

            $conn = DatabaseHelper::DBconnection();

            $sql = "SELECT * FROM users WHERE username=? and password=?";

            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            $result = $stmt->get_result();

            if($result->num_rows == 1) {
                return true;
            } else {
                return false;
            }

            $stmt->close();

            mysqli_close($conn);
        }

        public function hasAuthAdmin (string $username, string $password) {
            if($this->isSessionHijacked()) {
                return false;
            } else if($username == 'Admin' && $password == 'Password') {
                return true;

            } else if ($username == 'Admin' && $password == md5('Password')) {
                return true;

            } else {
                return false;

            }
        }

        public function isSessionHijacked(): bool {
            if(isset($_SESSION[self::$browser]) && $_SESSION[self::$browser] !== $_SERVER[self::$httpUserAgent]) {
                $this->message = '';
                $_SESSION[self::$login] = null;

                session_destroy();
                header('Location: /Lab3_1DV610_vf222cg/startup/');
                return true;
            } else {
                return false;
            }
        }

        public function setSessionUsername (string $username): void {
            $_SESSION[self::$name] = $username;

        }

        public function setSessionLogIn (bool $isLoggedIn): void {
            $_SESSION[self::$login] = $isLoggedIn;

        }

        public function setWelcomeMsg (bool $authWithCookie, bool $willBeRemembered): void {
            
            if ($willBeRemembered == true) {
                $this->message = 'Welcome and you will be remembered';
            } else if($authWithCookie == false) {
                $this->message = 'Welcome';
            } else {
                $this->message = 'Welcome back with cookie';
            }
        }

        public function setErrorMsg(bool $authWithCookie, bool $willBeRemembered): void {
            if ($authWithCookie == true) {
                $this->message = 'Wrong information in cookies';
            } else {
                $this->message = 'Wrong name or password';
            }
        }

        public function unsetCookies () {
            unset($_COOKIE['username']);
            unset($_COOKIE['password']);
            setcookie ('password', '', time() - (86400 * 30));
            setcookie ('username', '', time() - (86400 * 30));
        }

        public function getUsername (): bool {
            if (isset($_SESSION[self::$name])) {
                return $_SESSION[self::$name];
            } else {
                return false;
            }
        }

        public function hashPassword (string $password): string {
            return md5($password);
        }

        public function rememberUser (string $username, string $password): void {
            setcookie('username', $username, time() + (86400 * 30));
            setcookie('password', $password, time() + (86400 * 30));
        }

        public function destroySession(): void {
            $_SESSION[self::$login] = null;
            $_SESSION[self::$refreshed] = null;

            $this->message = 'Bye bye!';
        }

        public function isSessionRefreshed (): bool {
            if(isset($_SESSION['refreshed'])) {
                return true;
            } else {
                return false;
            }
        }

        public function setSessionRefreshed (bool $isRefreshed): void {
            if($this->isSessionRefreshed()){
                $_SESSION['refreshed'] = $isRefreshed;
            }
        }

        public function isSessionLogoutRefreshed (): bool {
            if(isset($_SESSION['logoutRefresh'])) {
                return true;
            } else {
                return false;
            }
        }

        public function setSessionLogoutRefreshed (bool $isRefreshed): void {
            if($this->isSessionLogoutRefreshed()){
                $_SESSION['logoutRefresh'] = $isRefreshed;
            }
        }
    }