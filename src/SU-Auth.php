<?php

// this is just an architecture example

if (!LPAuth::isLoggedIn())
{
    $user           = new LPAuth;
    $user->handle   = 'user@gmail.com';
    $user->password = 'TEST123'; // such a BAD password

    if ($user->login())
    {
        // ....
    }
}
 
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
    public $handle;
    public $password;
 
    public function __construct(array $credentials)
    {
        if (isset($credentials['handle'])   $this->handle = $credentials['handle'];
        if (isset($credentials['password']) $this->password = $credentials['password'];
    }
    
    public static function isLoggedIn()
    {
        $cookie_name = 'user';
        return TRUE; // cross domain
 
        if (!isset($_COOKIE[$cookie_name]))
        {
            return FALSE;
        }
        else
        {
            if ($_COOKIE[$cookie_name] == 'user@gmail.com')
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }
 
    public static function user()
    {
        $user = new stdClass;
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
        $hash = password_hash($password, PASSWORD_BCRYPT);
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