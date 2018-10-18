<?php
    class RegisterView {
        private static $name = 'RegisterView::UserName';
        private static $password = 'RegisterView::Password';
        private static $passwordRepeat = 'RegisterView::PasswordRepeat';

        public function response () {
            
            $response = $this->generateRegisterFormHTML();
            return $response;
        }
        private function generateRegisterFormHTML() {
            return "
                <h2>Register new user</h2>
                <form action='?register' method='post' enctype='multipart/form-data'>
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id='RegisterView::Message'></p>
                        <label for='RegisterView::UserName' >Username :</label>
                        <input type='text' size='20' name='RegisterView::UserName' id='RegisterView::UserName' value='' />
                        <br/>
                        <label for='RegisterView::Password' >Password  :</label>
                        <input type='password' size='20' name='RegisterView::Password' id='RegisterView::Password' value='' />
                        <br/>
                        <label for='RegisterView::PasswordRepeat' >Repeat password  :</label>
                        <input type='password' size='20' name='RegisterView::PasswordRepeat' id='RegisterView::PasswordRepeat' value='' />
                        <br/>
                        <input id='submit' type='submit' name='DoRegistration'  value='Register' />
                        <br/>
                    </fieldset>
                </form>
            ";
        }

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

        public function getRequestPassWordRepeat () {
            if(isset($_POST[self::$passwordRepeat])) {
                return $_POST[self::$passwordRepeat];
            } else {
                return false;
            }
        }

        public function getButton () {
            return "<a href='?'>Back to login</a>";
        }
    }