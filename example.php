<?php
define('DS'  , DIRECTORY_SEPARATOR);
define('PATH', rtrim(dirname(__FILE__), '/\\') . DS);

include PATH . 'src' . DS . 'index.php';

file_put_contents(PATH . 'examples' . DS . 'file_to_assemble1.wsa', obfuscate(file_get_contents(PATH . 'examples' . DS . 'file_to_assemble1.php')));

try {
    include_o(PATH . 'examples' . DS . 'file_to_assemble1s.wsa');
} catch(Exception $e) {
    echo "Sorry, there is some error :( -- \"{$e->getMessage()}\"";
}