<?php

// this is just an architecture exampl

namespace SUAuth
{
    require_once 'config.php';

    use SUAuth\Config\Config;

    interface iSUAuth
    {
        public static function isLoggedIn();
        public static function user();
        public function login();
        public static function create($password);
        public static function validatePassword($password);

    }

    class SUAuth implements iSUAuth
    {
        /* @var string $handle */
        public $handle;

        /* @var string $password */
        public $password;

        public function __construct(array $credentials = NULL)
        {
            if (isset($credentials['handle'])   && !empty($credentials['handle']))   $this->handle   = $credentials['handle'];
            if (isset($credentials['password']) && !empty($credentials['password'])) $this->password = $credentials['password'];
        }

        public static function isLoggedIn()
        {
            if (!isset($_COOKIE[Config::Name]) && !empty($_COOKIE[Config::Name])) // TODO: for password also
            {
                return FALSE;
            }
            else
            {
                $Auth = new self;
                if ($Auth->validateLogin($_COOKIE[Config::Name], $_COOKIE[Config::Password]) === TRUE)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
        }

        /**
         * Validates the user login through the database
         *
         * @param string $handle
         * @param string $password
         *
         * @return bool
         */
        private function validateLogin($handle, $password)
        {
            // TODO: integrate Stash Queries into this
            return true;
        }

        public static function user()
        {
            $user = new \stdClass;
            $user->id = 1;

            return $user;
        }

        public function login()
        {
            // validates log in credentials
            if ($this->handle == 'user@gmail.com' && $this->password == 'TEST123')
            {
                $cookie_name  = 'user'; // turn into a constant
                $cookie_value = $this->handle;
                $day          = 86400;  // 86400 = 1 day

                // 10 years cookie
                if (setcookie($cookie_name, $cookie_value, time() + ($day * 30 * 12 * 10), '/'))
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                return FALSE;
            }

        }

        public static function create($password)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }

        public static function validatePassword($password)
        {
            //$storedPasswordHash = DB::getPassword($user);
            $storedPasswordHash = '';
            if (password_verify($password, $storedPasswordHash))
            {
                /* Valid */
                return TRUE;
            }
            else
            {
                /* Invalid */
                return FALSE;
            }
        }

    }
}
