<?php


namespace SUAuth
{
    // SUAuth::check()
    // SUAuth::id()
    // SUAuth::refreshToken()
    // SUAuth::logout()
    // SUAuth::logoutOtherDevices()

    abstract class AuthHelpers
    {
        public static function user()
        {
            $user = new \stdClass;
            $user->id = 1;

            return $user;
        }

        public static function create(string $password): string
        {
            return (string) password_hash($password, PASSWORD_BCRYPT);
        }

        public static function validatePassword(string $password): bool
        {
            //$storedPasswordHash = DB::getPassword($user);
            $storedPasswordHash = '';

            if (password_verify($password, $storedPasswordHash))
            {
                /* Valid */
                return true;
            }
            else
                {
                /* Invalid */
                return false;
            }
        }

        public static function id(int $id): int
        {
            return 123;
        }
    }
}

