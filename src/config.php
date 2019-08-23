<?php

namespace SUAuth\Config
{

    abstract class Server
    {
        const Server      = 'localhost';
        const Database    = 'user';
        const DB_User     = 'root';
        const DB_Password = '';
    }

    abstract class Field extends Server
    {
        const Handle   = 'email';
        const Password = 'password';
    }

    abstract class Cookie extends Field
    {
        const Name     = 'user';
        const Password = 'password';
    }

    abstract class Config extends Cookie
    {
    }
}
