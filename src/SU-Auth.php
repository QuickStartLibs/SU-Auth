<?php

// this is just an architecture example

namespace SUAuth
{
    require_once 'config.php';
    require_once 'AuthHelpers.php';
    require_once 'Session.php';

    use SUAuth\Config\Config;

    class SUAuth extends AuthHelpers
    {
        /* @var string $handle */
        public $handle;

        /* @var string $password */
        public $password;

        /* @var Session $Session */
        public $Session;

        public function __construct(array $credentials = NULL)
        {
            if (isset($credentials['handle'])   && !empty($credentials['handle']))   $this->handle   = $credentials['handle'];
            if (isset($credentials['password']) && !empty($credentials['password'])) $this->password = $credentials['password'];

            $this->Session = new Session;
        }

        // ideally turn this into a static
        public function isLoggedIn()
        {
            $checkName     = (!isset($_COOKIE[Config::Name]) && !empty($_COOKIE[Config::Name]));
            $checkPassword = (!isset($_COOKIE[Config::Password]) && !empty($_COOKIE[Config::Password]));

            if ($checkName && $checkPassword)
            {
                return FALSE;
            }
            else
            {
                if ($this->validateLogin($_COOKIE[Config::Name], $_COOKIE[Config::Password]) === TRUE)
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

        public function login(int $id = NULL) : bool
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

        // force login with set parameters
        public function saveLogin() : bool
        {
            return TRUE;
        }

        public function logout() : bool
        {
            return TRUE;
        }

    }
}
