<?php

/**
 * Translate input string (php-code) into spaces and tabs
 * @param string $code
 * @return string
 */
function obfuscate($code)
{
    $obf  = '';
    $code = preg_replace('/^(<\?php|<\?)/', '', $code);
    $len  = strlen($code);
   
    for ($i = 0; $i < $len; $i++) {
        // Get and convert the view of symbol with i-index into binary
        $bin = decbin(ord($code[$i]));
        // If length of value of $bin is LT 8 then write zeroes
        $bin = ($binLen = strlen($bin) > 7)
                 ? $bin
                 : implode('', array_fill(0, 8 - strlen($bin), '0')) . $bin;
        // Now, replace 1 with tabs and 0 with spaces and concat with already existing string
        $obf .= str_replace(array('1', '0'), array(chr(9), chr(32)), $bin);
    }
   
    return $obf;
}

/**
 * Include .wsa file and execute it
 * @param string $file
 * @return void
 */
function include_o($file)
{
    $file = trim($file);
    // Check file for existing
    if ( empty($file)
     ||  !is_readable($file)
    ) {
        throw new Exception("Filename is empty or file isn't readable");
    }
   
    $string = file_get_contents($file);
    $len    = strlen($string);
    $out    = '';
   
    for ($i = 0; $i < $len; $i+=8) {
        /*
         * Every 8 symbols replace with 0 and 1,
         * Convert from binary to decimal and replace with symbol
         */
        $out .= chr(bindec(str_replace(array(chr(9), chr(32)), array('1', '0'), substr($string, $i, 8))));
    }
   
    if (!empty($out))
        eval($out);
}