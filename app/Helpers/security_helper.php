<?php 
//define('SALT_LENGTH', 15);
if(!function_exists('hashMe'))
{
    function hashMe($phrase, &$salt = null)
    {
        $slen = 15;
        $key = '@#!$%^*()&_+=-{}[];";/?><.,';
        if ($salt == '' || $salt == null)
        {
            $salt = substr(hash('sha512',uniqid(rand(), true).$key.microtime()), 0, $slen);
        }
        else
        {
            $salt = substr($salt, 0, $slen);
        }

        return hash('sha512',$salt . $key .  $phrase);
    }
}