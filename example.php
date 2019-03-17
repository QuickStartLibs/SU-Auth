<?php

use SUAuth\SUAuth;

require_once 'src/SU-Auth.php';

var_dump(SUAuth::create('bluebeans123'));

if (!SUAuth::isLoggedIn())
{
    $user           = new SUAuth;
    $user->handle   = 'user@gmail.com';
    $user->password = 'TEST123'; // such a BAD password

    /*
    if ($user->login())
    {
        // ....
    }
    */
}
