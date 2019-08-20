<?php

namespace SUAuth
{
    class Password
    {
        const METHOD = 'aes-256-cbc';

        public static function random($length = 8, $prefix = '')
        {
            // start with a blank password or defined prefix
            $password = $prefix;
            // set up a counter for how many characters are in the password so far
            $i = 0;

            // define possible characters - any character in this string can be
            // picked for use in the password, so if you want to put vowels back in
            // or add special characters such as exclamation marks, this is where
            // you should do it
            $possible = '2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ';

            // we refer to the length of $possible a few times, so let's grab it now
            $maxlength = strlen($possible);

            // check for length overflow and truncate if necessary
            if ($length > $maxlength)
            {
                $length = $maxlength;
            }

            // add random characters to $password until $length is reached
            while ($i < $length)
            {

                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, $maxlength-1), 1);

                // have we already used this character in $password?
                if (!strstr($password, $char))
                {
                    // no, so it's OK to add it onto the end of whatever we've already got...
                    $password .= $char;

                    $i++; // ... and increase the counter by one
                }
            }

            return $password;
        }

        public static function encrypt($message, $key)
        {
            if (mb_strlen($key, '8bit') !== 32)
            {
                throw new \Exception("Needs a 256-bit key!");
            }

            $ivsize = openssl_cipher_iv_length(self::METHOD);
            $iv     = openssl_random_pseudo_bytes($ivsize);

            $ciphertext = openssl_encrypt(
                $message,
                self::METHOD,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            return $iv.$ciphertext;
        }

        public static function decrypt($message, $key)
        {
            if (mb_strlen($key, '8bit') !== 32)
            {
                throw new \Exception('Needs a 256-bit key!');
            }

            $ivsize     = openssl_cipher_iv_length(self::METHOD);
            $iv         = mb_substr($message, 0, $ivsize, '8bit');
            $ciphertext = mb_substr($message, $ivsize, NULL, '8bit');

            return openssl_decrypt(
                $ciphertext,
                self::METHOD,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
        }
    }

    /* REQUIRE TESTING
    $salt = Password::random();

    try {
        // encrypt
        $crypted_password = Password::encrypt('YOUR_PASSWORD', $salt);

        // decrypt
        echo Password::decrypt($crypted_password, $salt);
    } catch (\Exception $exception)
    {
        var_dump($exception);
    }
    */

}